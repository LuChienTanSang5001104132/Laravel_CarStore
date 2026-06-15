<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // ── 1. LẤY DANH SÁCH ĐƠN HÀNG ──
    public function index(Request $request)
    {
        $query = Order::with([
            'user:id,name,email,phone',
            'items.car:id,name,brand_id,featured_image',
            'items.car.brand:id,name',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) =>
                    $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                )
                ->orWhere('customer_full_name', 'like', "%{$search}%")
                ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate($request->get('per_page', 10));

        // Nếu gọi từ API (Thầy chấm điểm)
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $orders
            ]);
        }

        // Nếu gọi từ Giao diện Web (Blade)
        return view('admin.orders.index', compact('orders'));
    }

    // ── 2. XEM CHI TIẾT 1 ĐƠN HÀNG ──
    public function show(Request $request, $id)
    {
        $order = Order::with(['user', 'items.car.brand'])->findOrFail($id);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $order
            ]);
        }

        return view('admin.orders.show', compact('order'));
    }

    // ── 3. CẬP NHẬT TRẠNG THÁI GIAO HÀNG ──
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Tự động cập nhật thanh toán nếu đã giao hàng thành công (trừ COD)
        if ($request->status === 'delivered' && $order->payment_method !== 'cod') {
            $order->update(['payment_status' => 'paid']);
        }

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Đơn hàng #{$id} đã chuyển từ '{$oldStatus}' → '{$request->status}'",
                'data'    => $order->fresh()
            ]);
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    // ── 4. CẬP NHẬT TRẠNG THÁI THANH TOÁN ──
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid,refunded',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->payment_status]);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thanh toán thành công',
                'data'    => $order->fresh()
            ]);
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái thanh toán thành công!');
    }

    // ── 5. XÓA ĐƠN HÀNG ──
    public function destroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!in_array($order->status, ['cancelled', 'pending'])) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ có thể xóa đơn hàng đang chờ xử lý hoặc đã hủy'
                ], 422);
            }
            return redirect()->back()->with('error', 'Chỉ có thể xóa đơn hàng đang chờ xử lý hoặc đã hủy!');
        }

        $order->items()->delete();
        $order->delete();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa đơn hàng thành công'
            ]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công!');
    }
}