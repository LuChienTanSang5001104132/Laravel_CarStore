<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CartItem; // Model quản lý giỏ hàng
use App\Models\Car;      // Model quản lý xe

class CartController extends Controller
{
    /**
     * XEM GIỎ HÀNG (Lấy danh sách xe trong giỏ của User)
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Lấy giỏ hàng kèm theo thông tin chi tiết của xe (Nối bảng)
        // Lưu ý: Đảm bảo model CartItem của bạn có hàm car() định nghĩa quan hệ belongsTo(Car::class)
        $cartItems = CartItem::with('car')->where('user_id', $userId)->get();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $cartItems
        ], 200);
    }

    /**
     * THÊM XE VÀO GIỎ HÀNG
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $userId = $request->user()->id;
        $carId = $request->car_id;
        $quantity = $request->quantity ?? 1;

        // Lấy giá xe hiện tại từ bảng cars
        $car = Car::find($carId);

        // Kiểm tra xem xe này đã có trong giỏ của user chưa
        $cartItem = CartItem::where('user_id', $userId)
                            ->where('car_id', $carId)
                            ->first();

        if ($cartItem) {
            // Nếu đã có -> Cộng dồn số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Nếu chưa có -> Tạo bản ghi mới
            $cartItem = CartItem::create([
                'user_id' => $userId,
                'car_id' => $carId,
                'quantity' => $quantity,
                'price' => $car->price // Lấy giá từ bảng xe
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => 'Đã thêm xe vào giỏ hàng',
            'data' => $cartItem
        ], 201);
    }

    /**
     * CẬP NHẬT SỐ LƯỢNG (Dành cho nút + / - trong giỏ hàng)
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Tìm item trong giỏ dựa theo ID của dòng giỏ hàng (không phải ID của xe) và ID user
        $cartItem = CartItem::where('id', $id)
                            ->where('user_id', $request->user()->id)
                            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'Không tìm thấy sản phẩm trong giỏ'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => 'Cập nhật số lượng thành công',
            'data' => $cartItem
        ], 200);
    }

    /**
     * XÓA XE KHỎI GIỎ HÀNG
     */
    public function destroy(Request $request, string $id)
    {
        $cartItem = CartItem::where('id', $id)
                            ->where('user_id', $request->user()->id)
                            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'Không tìm thấy sản phẩm trong giỏ'], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng'
        ], 200);
    }
}