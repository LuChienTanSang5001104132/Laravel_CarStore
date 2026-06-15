@extends('admin.layout.app')

@section('title', 'Dashboard')
@section('header', 'Tổng Quan')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow p-6 card-hover border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Tổng Doanh Thu</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($overview['total_revenue'] ?? 0) }} ₫</p>
                </div>
                <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-2xl text-green-500 shadow-sm"><i class="fas fa-wallet"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 card-hover border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Tổng Đơn Hàng</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($overview['total_orders'] ?? 0) }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-2xl text-blue-500 shadow-sm"><i class="fas fa-shopping-bag"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 card-hover border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Khách Hàng</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ number_format($overview['total_customers'] ?? 0) }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-2xl text-purple-500 shadow-sm"><i class="fas fa-users"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 card-hover border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Sản Phẩm Đang Bán</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ number_format($overview['total_cars'] ?? 0) }}</p>
                </div>
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-2xl text-orange-500 shadow-sm"><i class="fas fa-car"></i></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-chart-line text-blue-500"></i> Doanh Thu 6 Tháng Gần Nhất</h3>
            <canvas id="revenueChart" height="120"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-fire text-red-500"></i> Top 5 Xe Bán Chạy Nhất</h3>
            <div class="space-y-4">
                @forelse($top_cars ?? [] as $car)
                <div class="flex items-center gap-4 bg-gray-50/50 p-3 rounded-xl border border-gray-50 hover:bg-white hover:shadow-sm transition-all duration-200">
                    <img src="{{ $car->image ? asset('storage/' . $car->image) : asset('Image/' . $car->name . '.jpg') }}" class="w-16 h-12 object-contain bg-white rounded-lg shadow-sm border border-gray-100" onerror="this.src='https://via.placeholder.com/80x50?text=Car'">
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 truncate">{{ $car->name }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $car->brand ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-green-600">{{ number_format($car->total_sold) }} <span class="text-xs font-medium text-gray-500">xe</span></p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <i class="fas fa-box-open text-3xl text-gray-300 mb-2"></i>
                    <p class="text-gray-400 text-sm">Chưa có dữ liệu giao dịch nào hoàn tất.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Nhận dữ liệu mảng PHP trả về thẳng vào biến Javascript
    const revenueData = @json($revenue_last_6_months ?? []);
    
    if(revenueData && revenueData.length > 0) {
        const ctx = document.getElementById('revenueChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: revenueData.map(m => m.month),
                datasets: [{
                    label: 'Doanh Thu (triệu ₫)',
                    data: revenueData.map(m => (m.revenue / 1000000).toFixed(1)), // Đổi ra triệu đồng cho dễ nhìn biểu đồ
                    borderColor: '#2563eb', // blue-600
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Triệu ₫';
                            }
                        }
                    }
                },
                scales: { 
                    y: { 
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endsection