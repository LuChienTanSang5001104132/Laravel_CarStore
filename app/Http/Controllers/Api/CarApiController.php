<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;

class CarApiController extends Controller
{
    /**
     * Lấy danh sách xe (Dùng cho trang Mẫu Xe)
     * Có hỗ trợ lọc theo tìm kiếm, hãng xe, loại xe
     */
    public function index(Request $request)
    {
        // 1. Gọi Model Car và nối với bảng Brand (Hãng xe)
        $query = Car::with('brand');

        // 2. Lọc theo trạng thái (Ví dụ: khách hàng chỉ thấy xe đang kích hoạt status = 1)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Lọc theo tên xe (Tìm kiếm gần đúng)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 4. Lọc theo Hãng xe
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // 5. Lọc theo Phân khúc (Loại xe)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 6. Phân trang (Mỗi trang hiện 9 chiếc)
        $cars = $query->latest()->paginate(9);

        // Trả về dữ liệu dạng JSON cho JavaScript xử lý
        return response()->json([
            'success' => true,
            'data'    => $cars
        ]);
    }

    /**
     * Lấy chi tiết 1 chiếc xe (Dùng cho trang Chi Tiết Xe)
     */
    public function show($id)
    {
        // Tạm thời chỉ load bảng Brand (Hãng xe) cho an toàn. 
        // Các bảng images, reviews, orderItems sẽ gây lỗi nếu Model Car chưa khai báo.
        $car = Car::with('brand')->find($id);

        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy xe này!'
            ], 404);
        }

        // Tự động tăng lượt xem
        $car->increment('views');

        return response()->json([
            'success' => true,
            'data'    => $car
        ]);
    }
}