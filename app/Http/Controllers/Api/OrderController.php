<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Car;

class OrderController extends Controller
{
    /**
     * LỊCH SỬ MUA HÀNG (User xem đơn hàng của mình)
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
                       ->with('items.car') // Load thông tin xe của từng đơn hàng
                       ->latest()
                       ->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }

    /**
     * TẠO ĐƠN HÀNG / THANH TOÁN
     */
    public function store(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'customer_full_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|string'
        ]);

        $userId = $request->user()->id;
        $cartItems = CartItem::where('user_id', $userId)->with('car')->get();

        // 2. Kiểm tra giỏ hàng
        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Giỏ hàng của bạn đang trống'], 400);
        }

        // Bắt đầu Transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::beginTransaction();
        try {
            // Kiểm tra tồn kho trước khi tạo đơn
            foreach ($cartItems as $item) {
                if (!$item->car || $item->car->quantity < $item->quantity) {
                    throw new \Exception("Sản phẩm '{$item->car->name}' không đủ số lượng trong kho.");
                }
            }

            // 3. Tính tổng tiền
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            // 4. Tạo hóa đơn (Order)
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'customer_full_name' => $request->customer_full_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
            ]);

            // 5. Tạo chi tiết đơn hàng (OrderItem) và trừ tồn kho
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'car_id' => $item->car_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ]);

                // Trừ số lượng xe trong bảng cars
                Car::where('id', $item->car_id)->decrement('quantity', $item->quantity);
            }

            // 6. Xóa sạch giỏ hàng
            CartItem::where('user_id', $userId)->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Đặt hàng thành công!',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * XEM CHI TIẾT ĐƠN HÀNG
     */
    public function show(Request $request, string $id)
    {
        $order = Order::where('id', $id)
                      ->where('user_id', $request->user()->id)
                      ->with('items.car')
                      ->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Đơn hàng không tồn tại'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $order], 200);
    }

    /**
     * HỦY ĐƠN HÀNG
     */
    public function cancel(Request $request, string $id)
    {
        $order = Order::where('id', $id)
                      ->where('user_id', $request->user()->id)
                      ->with('items') // Cần items để cộng lại kho
                      ->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Đơn hàng không tồn tại'], 404);
        }

        if ($order->status !== 'pending') {
            return response()->json(['status' => 'error', 'message' => 'Không thể hủy đơn hàng đã xử lý'], 400);
        }

        DB::beginTransaction();
        try {
            // Cộng lại số lượng xe vào kho
            foreach ($order->items as $item) {
                Car::where('id', $item->car_id)->increment('quantity', $item->quantity);
            }

            $order->update(['status' => 'cancelled']);
            
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Đã hủy đơn hàng và hoàn lại kho'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Không thể hủy đơn: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GIẢ LẬP XÁC NHẬN THANH TOÁN (Dùng cho test)
    */
    public function confirmPayment(Request $request, string $id)
    {
        $order = Order::where('id', $id)
                    ->where('user_id', $request->user()->id)
                    ->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Đơn hàng không tồn tại'], 404);
        }

        // Cập nhật trạng thái
        $order->update([
            'payment_status' => 'paid',
            'status'         => 'confirmed' // Đơn hàng đã được xác nhận
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Xác nhận thanh toán thành công (Giả lập)',
            'data' => $order
        ], 200);
    }
}