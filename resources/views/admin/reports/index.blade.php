@extends('admin.layout.app')

@section('title', 'Báo Cáo & Thống Kê')
@section('header', 'Tổng Quan Hoạt Động')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Báo Cáo Hoạt Động Kinh Doanh</h2>
            <p class="text-sm text-gray-500 mt-1">Các chỉ số quan trọng và tình hình doanh thu của hệ thống.</p>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.reports.excel') }}" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow transition-colors text-sm">
                <i class="fas fa-file-excel mr-2"></i> Xuất Excel
            </a>
            
            <a href="{{ route('admin.reports.pdf') }}" target="_blank" class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow transition-colors text-sm">
                <i class="fas fa-file-pdf mr-2"></i> Xuất PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card Doanh thu --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-green-100 text-sm font-semibold mb-1">Tổng Doanh Thu</p>
                    <h3 class="text-2xl font-bold">{{ number_format($total_revenue) }} ₫</h3>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-xl">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>

        {{-- Card Đơn hàng --}}
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-blue-100 text-sm font-semibold mb-1">Tổng Đơn Hàng</p>
                    <h3 class="text-3xl font-bold">{{ number_format($total_orders) }}</h3>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-xl">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>

        {{-- Card Khách hàng --}}
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-purple-100 text-sm font-semibold mb-1">Khách Hàng</p>
                    <h3 class="text-3xl font-bold">{{ number_format($total_customers) }}</h3>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-xl">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        {{-- Card Số lượng xe --}}
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-orange-100 text-sm font-semibold mb-1">Xe Đang Bán</p>
                    <h3 class="text-3xl font-bold">{{ number_format($totalCars) }}</h3>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-xl">
                    <i class="fas fa-car"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Top Xe Bán Chạy Nhất</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm font-semibold">
                        <th class="p-4">#</th>
                        <th class="p-4">Tên Xe</th>
                        <th class="p-4">Hãng Xe</th>
                        <th class="p-4">Số Lượng Bán</th>
                        <th class="p-4">Tổng Doanh Thu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($top_cars as $index => $car)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 font-bold text-gray-500">{{ $index + 1 }}</td>
                        <td class="p-4 font-semibold text-gray-900">{{ $car->name }}</td>
                        <td class="p-4 text-blue-600 font-medium">{{ $car->brand }}</td>
                        <td class="p-4 font-bold text-orange-600">{{ $car->total_sold }} chiếc</td>
                        <td class="p-4 font-bold text-green-600">{{ number_format($car->total_revenue) }} ₫</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">Chưa có dữ liệu thống kê.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection