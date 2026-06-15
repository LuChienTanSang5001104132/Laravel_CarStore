@extends('layouts.app')

@section('title', 'Cập Nhật Xe')
@section('header', 'Chỉnh Sửa Thông Tin Xe')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6 md:p-8">
    <div class="mb-6 border-b border-gray-100 pb-4 flex items-center gap-3">
        <a href="{{ route('admin.cars.index') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Chỉnh sửa: <span class="text-blue-600">{{ $car->name }}</span></h2>
    </div>

    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- THÔNG TIN CƠ BẢN --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i> Thông Tin Cơ Bản
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên xe</label>
                    <input type="text" name="name" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $car->name }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hãng xe</label>
                    <select name="brand_id" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $car->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Giá bán (₫)</label>
                    <input type="number" name="price" min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ intval($car->price) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng kho</label>
                    <input type="number" name="quantity" min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $car->quantity }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Năm sản xuất</label>
                    <input type="number" name="year" min="1900" max="{{ date('Y')+1 }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $car->year }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phân khúc xe</label>
                    <select name="type" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Chọn loại xe --</option>
                        @foreach(['SUV','Sedan','Hatchback','Pickup','MPV','Crossover','Coupe'] as $type)
                            <option value="{{ $type }}" {{ $car->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Màu sắc</label>
                    <input type="text" name="color" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $car->color }}" placeholder="Ví dụ: Trắng, Đen, Đỏ...">
                </div>
            </div>
        </div>

        {{-- THÔNG SỐ KỸ THUẬT --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                <i class="fas fa-cogs text-orange-500"></i> Thông Số Kỹ Thuật
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nhiên liệu</label>
                    <select name="fuel_type" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Chọn nhiên liệu --</option>
                        @foreach(['Xăng','Dầu','Điện','Hybrid','Plug-in Hybrid'] as $fuel)
                            <option value="{{ $fuel }}" {{ $car->fuel_type == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hộp số</label>
                    <select name="transmission" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Chọn hộp số --</option>
                        @foreach(['Tự động','Sàn','CVT','DCT'] as $trans)
                            <option value="{{ $trans }}" {{ $car->transmission == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dung tích động cơ</label>
                    <input type="text" name="engine_capacity" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $car->engine_capacity }}" placeholder="Ví dụ: 2.0L, 1.5T...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Số chỗ ngồi</label>
                    <select name="seats" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Chọn số chỗ --</option>
                        @foreach([2,4,5,7,8,9] as $seat)
                            <option value="{{ $seat }}" {{ $car->seats == $seat ? 'selected' : '' }}>{{ $seat }} chỗ</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- ẢNH & MÔ TẢ --}}
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                <i class="fas fa-image text-purple-500"></i> Ảnh & Mô Tả
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thay đổi ảnh mới (Để trống nếu giữ ảnh cũ)</label>
                    @if($car->featured_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $car->featured_image) }}" class="w-32 h-20 object-cover rounded-xl shadow-sm border">
                        </div>
                    @endif
                    <input type="file" name="featured_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">{{ $car->description }}</textarea>
                </div>
            </div>
        </div>

        {{-- TRẠNG THÁI --}}
        <div class="flex items-center">
            <input type="checkbox" name="status" id="status" value="1" {{ $car->status ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="status" class="ml-2 text-sm text-gray-700 font-medium">Kích hoạt mở bán</label>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
            <a href="{{ route('admin.cars.show', $car->id) }}" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">Hủy</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow transition-colors">
                <i class="fas fa-save mr-2"></i> Cập nhật ngay
            </button>
        </div>
    </form>
</div>
@endsection