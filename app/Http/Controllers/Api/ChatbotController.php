<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Car;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->message;

        // Lấy danh sách xe
        $cars = Car::with('brand')
                    ->where('status', 1)
                    ->where('quantity', '>', 0)
                    ->limit(30)
                    ->get(['name', 'price', 'quantity', 'brand_id']);

        $carContext = "Danh sách xe cửa hàng đang có:\n";
        foreach ($cars as $car) {
            $brandName = $car->brand ? $car->brand->name : 'Chưa rõ';
            $price = number_format($car->price, 0, ',', '.') . ' VNĐ';
            $carContext .= "- Xe {$car->name} (Hãng: {$brandName}) - Giá: {$price} - Còn: {$car->quantity} chiếc.\n";
        }

        $systemPrompt = "Bạn là nhân viên tư vấn nhiệt tình, chuyên nghiệp của hệ thống bán xe CarStore.
        Hãy dựa vào thông tin kho xe sau đây để trả lời khách hàng:
        \n$carContext\n
        Quy tắc trả lời:
        1. Chỉ tư vấn các xe có trong danh sách trên. Nếu khách hỏi xe không có, hãy lịch sự xin lỗi và gợi ý xe khác cùng tầm giá.
        2. Trả lời ngắn gọn, súc tích, thân thiện và format bằng Markdown (in đậm giá tiền, tên xe).
        3. Không bịa đặt thông tin hoặc giá cả.";

        try {
            $apiKey = env('GROQ_API_KEY');
            if (!$apiKey) {
                throw new \Exception('Chưa cấu hình GROQ_API_KEY trong file .env');
            }

            $url = 'https://api.groq.com/openai/v1/chat/completions';
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(120)->post($url, [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage],
                ],
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

            if ($response->failed()) {
                $error = $response->json();
                $errorMsg = $error['error']['message'] ?? 'Không rõ lỗi';
                throw new \Exception('Groq API lỗi: ' . $errorMsg);
            }

            $data = $response->json();
            $aiReply = $data['choices'][0]['message']['content'] ?? 'Xin lỗi, tôi chưa hiểu câu hỏi của bạn.';

            return response()->json([
                'status' => 'success',
                'reply' => $aiReply
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'reply' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}