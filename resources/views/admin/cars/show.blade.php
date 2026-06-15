@extends('admin.layout.app')

@section('title', 'Chi Tiết Xe - ' . $car->name)
@section('header', 'Chi Tiết Xe')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.cars.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $car->name }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">Chi tiết thông tin xe</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.cars.edit', $car->id) }}"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow transition-colors text-sm">
                <i class="fas fa-edit mr-2"></i> Chỉnh Sửa
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Cột trái: Ảnh + Trạng thái --}}
        <div class="lg:col-span-1 flex flex-col gap-6">

            {{-- Ảnh chính (Đã sửa dùng Accessor image_url để tự động nhận dạng link) --}}
            <div class="bg-white rounded-2xl shadow p-4">
                <img src="{{ $car->image_url }}"
                     alt="{{ $car->name }}"
                     class="w-full h-56 object-contain rounded-xl bg-gray-50"
                     onerror="this.src='https://via.placeholder.com/800x500?text=CarStore'">
            </div>

            {{-- Trạng thái & Thống kê --}}
            <div class="bg-white rounded-2xl shadow p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Trạng thái</span>
                    @if($car->status)
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-circle text-[8px] mr-1"></i> Đang hoạt động
                        </span>
                    @else
                        <span class="bg-red-100 text-red-600 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-circle text-[8px] mr-1"></i> Ngừng kinh doanh
                        </span>
                    @endif
                </div>
                <div class="flex items-center justify-between border-t pt-3">
                    <span class="text-sm text-gray-500"><i class="fas fa-boxes mr-1 text-blue-400"></i> Tồn kho</span>
                    <span class="font-bold text-gray-800">{{ $car->quantity }} xe</span>
                </div>
                <div class="flex items-center justify-between border-t pt-3">
                    <span class="text-sm text-gray-500"><i class="fas fa-shopping-cart mr-1 text-orange-400"></i> Đã đặt</span>
                    <span class="font-bold text-gray-800">{{ $car->orderItems->count() ?? 0 }} đơn</span>
                </div>
                <div class="flex items-center justify-between border-t pt-3">
                    <span class="text-sm text-gray-500"><i class="fas fa-eye mr-1 text-purple-400"></i> Lượt xem</span>
                    <span class="font-bold text-gray-800">{{ number_format($car->views) }}</span>
                </div>
                @if($car->reviews && $car->reviews->count() > 0)
                <div class="flex items-center justify-between border-t pt-3">
                    <span class="text-sm text-gray-500"><i class="fas fa-star mr-1 text-yellow-400"></i> Đánh giá</span>
                    <span class="font-bold text-gray-800">{{ number_format($car->reviews->avg('rating'), 1) }} / 5 ({{ $car->reviews->count() }})</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Cột phải: Thông tin chi tiết --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- Thông tin cơ bản --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-500"></i> Thông Tin Cơ Bản
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Tên Xe</p>
                        <p class="font-semibold text-gray-800">{{ $car->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Hãng Xe</p>
                        <p class="font-semibold text-gray-800">{{ $car->brand->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Giá Bán</p>
                        <p class="font-bold text-green-600 text-lg">{{ number_format($car->price) }} ₫</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Năm Sản Xuất</p>
                        <p class="font-semibold text-gray-800">{{ $car->year }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Loại Xe</p>
                        <p class="font-semibold text-gray-800">{{ $car->type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Màu Sắc</p>
                        <p class="font-semibold text-gray-800">{{ $car->color ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Thông số kỹ thuật --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-cogs text-orange-500"></i> Thông Số Kỹ Thuật
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Nhiên Liệu</p>
                        <p class="font-semibold text-gray-800">{{ $car->fuel_type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Hộp Số</p>
                        <p class="font-semibold text-gray-800">{{ $car->transmission ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Dung Tích Động Cơ</p>
                        <p class="font-semibold text-gray-800">{{ $car->engine_capacity ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Số Chỗ Ngồi</p>
                        <p class="font-semibold text-gray-800">{{ $car->seats ? $car->seats . ' chỗ' : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            @if($car->description)
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-align-left text-purple-500"></i> Mô Tả
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $car->description }}</p>
            </div>
            @endif

            {{-- Đánh giá (nếu có) --}}
            @if($car->reviews && $car->reviews->count() > 0)
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-star text-yellow-400"></i> Đánh Giá Gần Đây
                </h3>
                <div class="flex flex-col gap-3">
                    @foreach($car->reviews->take(3) as $review)
                    <div class="border border-gray-100 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-sm text-gray-800">{{ $review->user->name ?? 'Ẩn danh' }}</span>
                            <span class="text-xs text-gray-400">{{ $review->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex gap-0.5 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                            @endfor
                        </div>
                        @if($review->comment)
                            <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection