<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Đã thêm Request $request vào tham số của hàm
    public function dashboard(Request $request)
    {
        // Chỉ tính doanh thu của các đơn đã thanh toán và không bị hủy
        $totalRevenue   = Order::where('payment_status', 'paid')->where('status', '!=', 'cancelled')->sum('total_amount');
        
        // Đếm số lượng đơn hàng hợp lệ (Đã thanh toán & Không hủy)
        $totalOrders    = Order::where('payment_status', 'paid')->where('status', '!=', 'cancelled')->count();
        
        $totalCustomers = User::where('role', 'user')->count();
        $totalCars      = Car::count();

        // Top 5 xe bán chạy (chỉ đếm đơn đã thanh toán & không hủy)
        $topCars = DB::table('order_items')
            ->join('cars', 'order_items.car_id', '=', 'cars.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('brands', 'cars.brand_id', '=', 'brands.id')
            ->where('orders.payment_status', 'paid')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'cars.id',
                'cars.name',
                'brands.name as brand',
                'cars.featured_image as image',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('cars.id', 'cars.name', 'brands.name', 'cars.featured_image')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Doanh thu 6 tháng gần nhất (chỉ tính đơn đã thanh toán & không hủy)
        $revenueLast6Months = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Đóng gói toàn bộ dữ liệu vào biến $data
        $data = [
            'overview' => [
                'total_revenue'   => $totalRevenue,
                'total_orders'    => $totalOrders,
                'total_customers' => $totalCustomers,
                'total_cars'      => $totalCars,
            ],
            'top_cars'              => $topCars,
            'revenue_last_6_months' => $revenueLast6Months,
        ];

        // Nếu hệ thống bị gọi qua API (Ví dụ: Thầy cô dùng Postman chấm điểm)
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        // DÀNH CHO WEB: Truyền thẳng dữ liệu $data ra giao diện Dashboard
        return view('admin.dashboard', $data);
    }
}