@extends('admin.layout.app')

@section('title', 'Quản Lý Xe')
@section('header', 'Danh Sách Xe')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Quản Lý Kho Xe</h2>
            <p class="text-sm text-gray-500 mt-1">Xem, tìm kiếm và điều chỉnh danh sách xe đang kinh doanh.</p>
        </div>
        <a href="{{ route('admin.cars.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
            <i class="fas fa-plus mr-2"></i> Thêm Xe Mới
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <form action="{{ route('admin.cars.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tìm theo tên xe, hãng..." value="{{ request('search') }}">
            </div>
            <div>
                <select name="brand_id" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Chọn Hãng Xe --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Trạng Thái --</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Ngừng kinh doanh</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-xl px-4 py-2 transition-colors">
                <i class="fas fa-filter mr-1"></i> Lọc kết quả
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
                        <th class="p-4">Hình Ảnh</th>
                        <th class="p-4">Tên Xe</th>
                        <th class="p-4">Hãng Xe</th>
                        <th class="p-4">Giá Bán</th>
                        <th class="p-4">Kho / Đơn</th>
                        <th class="p-4 text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($cars as $car)
                    <tr class="hover:bg-gray-50/50 transition-colors">

                        {{-- Đã sửa Hình Ảnh sử dụng Accessor image_url --}}
                        <td class="p-4">
                            <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="w-20 h-12 object-contain bg-gray-50 rounded-xl shadow-sm" onerror="this.src='https://via.placeholder.com/80x50?text=No+Image'">
                        </td>

                        {{-- Tên Xe --}}
                        <td class="p-4">
                            <p class="font-bold text-gray-900">{{ $car->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Năm SX: {{ $car->year }} | {{ $car->type }}</p>
                        </td>

                        {{-- Hãng Xe --}}
                        <td class="p-4 text-gray-600">{{ $car->brand->name ?? 'N/A' }}</td>

                        {{-- Giá Bán --}}
                        <td class="p-4 font-bold text-green-600">{{ number_format($car->price) }} ₫</td>

                        {{-- Kho / Đơn --}}
                        <td class="p-4 text-gray-600">
                            <div>Còn lại: <span class="font-semibold">{{ $car->quantity }}</span></div>
                            <div class="text-xs text-blue-500 mt-0.5">Đã đặt: {{ $car->order_items_count }} đơn</div>
                        </td>

                        {{-- Hành Động --}}
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.cars.show', $car->id) }}"
                                   class="text-gray-600 hover:text-gray-900 font-semibold bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                    <i class="fas fa-eye mr-1"></i> Chi Tiết
                                </a>

                                <a href="{{ route('admin.cars.edit', $car->id) }}"
                                   class="text-blue-600 hover:text-blue-900 font-semibold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                    <i class="fas fa-edit mr-1"></i> Sửa
                                </a>

                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa chiếc xe này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 font-semibold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                        <i class="fas fa-trash mr-1"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">Không tìm thấy chiếc xe nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $cars->appends(request()->query())->links() }}
    </div>
</div>
@endsection