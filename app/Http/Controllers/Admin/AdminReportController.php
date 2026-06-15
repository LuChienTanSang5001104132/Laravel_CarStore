<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getReportData($request);
        $data['totalCars'] = Car::count();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $data
            ]);
        }

        return view('admin.reports.index', $data);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);

        $pdf = Pdf::loadView('admin.reports.pdf', $data)
                  ->setPaper('a4', 'landscape')
                  ->setOptions(['defaultFont' => 'DejaVu Sans']);

        $filename = 'bao-cao-carstore-' . Carbon::now()->format('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $data     = $this->getReportData($request);
        $filename = 'bao-cao-carstore-' . Carbon::now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new ReportExport($data), $filename);
    }

    private function getReportData(Request $request): array
    {
        $year  = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        // Logic MỚI: Chỉ lấy đơn ĐÃ THANH TOÁN và KHÔNG BỊ HỦY
        $orderQuery = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->whereYear('created_at', $year);

        if ($month) {
            $orderQuery->whereMonth('created_at', $month);
        }

        $revenueByMonth = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $fullMonths = collect(range(1, 12))->map(function ($m) use ($revenueByMonth) {
            $found = $revenueByMonth->firstWhere('month', $m);
            return (object)[
                'month'   => $m,
                'revenue' => $found ? $found->revenue : 0,
                'orders'  => $found ? $found->orders  : 0,
            ];
        });

        $topCars = DB::table('order_items')
            ->join('cars', 'order_items.car_id', '=', 'cars.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('brands', 'cars.brand_id', '=', 'brands.id')
            ->where('orders.payment_status', 'paid')
            ->where('orders.status', '!=', 'cancelled')
            ->whereYear('orders.created_at', $year)
            ->when($month, fn($q) => $q->whereMonth('orders.created_at', $month))
            ->select(
                'cars.name',
                'brands.name as brand',
                'cars.price',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('cars.name', 'brands.name', 'cars.price')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return [
            'generated_at'    => Carbon::now()->format('d/m/Y H:i'),
            'year'            => $year,
            'month'           => $month,
            'total_revenue'   => (clone $orderQuery)->sum('total_amount'), 
            'total_orders'    => (clone $orderQuery)->count(),
            'total_customers' => User::where('role', 'user')->count(),
            'revenue_by_month'=> $fullMonths,
            'top_cars'        => $topCars,
        ];
    }
}