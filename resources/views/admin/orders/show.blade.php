@extends('layouts.app')

@section('title', 'Quản Lý Đơn Hàng')
@section('header', 'Danh Sách Đơn Đặt Xe')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
        <div>
            {{-- THANH ĐIỀU HƯỚNG BREADCRUMB --}}
            <div class="flex items-center gap-2 text-sm font-semibold text-gray-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">
                    <i class="fas fa-home mr-1"></i> Dashboard
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-blue-600">Quản lý đơn hàng</span>
            </div>

            <h2 class="text-2xl font-bold text-gray-800">Quản Lý Đơn Hàng</h2>
            <p class="text-sm text-gray-500 mt-1">Theo dõi và xử lý các đơn đặt hàng từ khách hàng.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-4">
            <select name="status" class="rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="shipping" {{ request('status') === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Đã hoàn thành</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-xl px-4 py-2 transition-colors">
                <i class="fas fa-filter mr-1"></i> Lọc đơn
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-xl text-green-700 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-xl text-red-700 text-sm shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm font-semibold">
                        <th class="p-4">Mã Đơn</th>
                        <th class="p-4">Khách Hàng</th>
                        <th class="p-4">Ngày Đặt</th>
                        <th class="p-4">Tổng Tiền</th>
                        <th class="p-4">Trạng Thái</th>
                        <th class="p-4 text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 font-bold text-blue-600">#{{ $order->id }}</td>
                        <td class="p-4">
                            <p class="font-bold text-gray-900">{{ $order->customer_full_name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->customer_phone }}</p>
                        </td>
                        <td class="p-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4 font-bold text-green-600">{{ number_format($order->total_amount) }} ₫</td>
                        <td class="p-4">
                            @if($order->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">Chờ xử lý</span>
                            @elseif($order->status === 'confirmed')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold">Đã xác nhận</span>
                            @elseif($order->status === 'shipping')
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-bold">Đang giao</span>
                            @elseif($order->status === 'delivered')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Hoàn thành</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Đã hủy</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                    <i class="fas fa-eye mr-1"></i> Xử lý
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">Không tìm thấy đơn hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection