@extends('admin.layout.app')

@section('title', 'Chi tiết đơn hàng')
@section('header', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-2 text-sm font-semibold text-gray-500 mb-4">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.orders.index') }}" class="hover:text-blue-600">Quản lý đơn hàng</a>
        <span>/</span>
        <span class="text-blue-600">Chi tiết #{{ $order->id }}</span>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-xl text-green-700 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Thông tin đơn hàng -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Thông tin đơn hàng</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="font-semibold text-gray-600">Mã đơn:</span>
                    <span class="text-gray-900">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-gray-600">Ngày đặt:</span>
                    <span class="text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-gray-600">Phương thức thanh toán:</span>
                    <span class="text-gray-900">{{ $order->payment_method ?? 'Chưa xác định' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-gray-600">Trạng thái thanh toán:</span>
                    <span class="text-gray-900">
                        @if($order->payment_status === 'paid')
                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">Đã thanh toán</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-xs">Chưa thanh toán</span>
                        @endif
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-gray-600">Trạng thái đơn hàng:</span>
                    <span class="text-gray-900">
                        @php
                            $statusLabels = [
                                'pending'   => 'Chờ xử lý',
                                'confirmed' => 'Đã xác nhận',
                                'shipping'  => 'Đang giao hàng',
                                'delivered' => 'Hoàn thành',
                                'cancelled' => 'Đã hủy'
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($order->status === 'confirmed') bg-blue-100 text-blue-700
                            @elseif($order->status === 'shipping') bg-purple-100 text-purple-700
                            @elseif($order->status === 'delivered') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-gray-600">Tổng tiền:</span>
                    <span class="text-xl font-bold text-blue-600">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</span>
                </div>
            </div>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Thông tin khách hàng</h3>
            <div class="space-y-3">
                <div>
                    <span class="font-semibold text-gray-600 block">Họ tên:</span>
                    <span class="text-gray-900">{{ $order->customer_full_name }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-600 block">Số điện thoại:</span>
                    <span class="text-gray-900">{{ $order->customer_phone }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-600 block">Địa chỉ giao hàng:</span>
                    <span class="text-gray-900">{{ $order->customer_address ?? 'Chưa cập nhật' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm trong đơn hàng -->
    <div class="mt-6 bg-white rounded-2xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Sản phẩm đã đặt</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase">
                    <tr>
                        <th class="px-6 py-3">Tên xe</th>
                        <th class="px-6 py-3">Hãng</th>
                        <th class="px-6 py-3 text-center">Số lượng</th>
                        <th class="px-6 py-3 text-right">Đơn giá</th>
                        <th class="px-6 py-3 text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @foreach($order->items as $item)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->car_name ?? 'Xe không xác định' }}</td>
                        <td class="px-6 py-4">{{ $item->brand_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-right">{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                        <td class="px-6 py-4 text-right font-semibold text-blue-600">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-right font-bold text-gray-800">Tổng cộng:</td>
                        <td class="px-6 py-3 text-right font-bold text-blue-600 text-lg">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Hành động cập nhật trạng thái -->
    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Quay lại</a>
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <select name="status" class="border rounded-lg px-3 py-2 text-sm">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
            <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Cập nhật trạng thái
            </button>
        </form>
    </div>
</div>
@endsection