@extends('layouts.app')


@section('title', 'Thêm Xe Mới')
@section('header', 'Thêm Xe Mới')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Breadcrumb / page intro --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Thêm xe mới vào kho</h1>
            <p class="text-sm text-gray-500 mt-1">Điền đầy đủ thông tin dưới đây để thêm xe vào danh sách bán.</p>
        </div>
        <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl p-4">
            <p class="font-semibold mb-1"><i class="fas fa-exclamation-circle mr-1"></i> Vui lòng kiểm tra lại các trường sau:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- THÔNG TIN CƠ BẢN --}}
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Thông tin cơ bản</h3>
                    <p class="text-xs text-gray-400">Tên, hãng, giá và phân loại xe</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tên xe <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                        placeholder="Ví dụ: VinFast VF8 Ultra">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Hãng xe <span class="text-red-500">*</span></label>
                    <select name="brand_id" required
                        class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        <option value="">-- Chọn hãng xe --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phân khúc xe <span class="text-red-500">*</span></label>
                    <select name="type" required
                        class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        <option value="">-- Chọn loại xe --</option>
                        @foreach(['SUV','Sedan','Hatchback','Pickup','MPV','Crossover','Coupe'] as $t)
                            <option value="{{ $t }}" @selected(old('type') == $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Giá bán (₫) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="price" value="{{ old('price') }}" required min="0" step="1"
                            inputmode="numeric" onkeydown="if(['e','E','+','-','.'].includes(event.key)) event.preventDefault();"
                            class="w-full rounded-xl border-gray-200 text-sm shadow-sm pr-12 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="Nhập số tiền">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">VNĐ</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Số lượng trong kho <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" required min="0" step="1"
                        inputmode="numeric" onkeydown="if(['e','E','+','-','.'].includes(event.key)) event.preventDefault();"
                        class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                        placeholder="Ví dụ: 10">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Năm sản xuất <span class="text-red-500">*</span></label>
                    <input type="number" name="year" required min="1900" max="9999" value="{{ old('year', date('Y')) }}"
                        inputmode="numeric" maxlength="4"
                        onkeydown="if(['e','E','+','-','.'].includes(event.key)) event.preventDefault();"
                        oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);"
                        class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Màu sắc</label>
                    <input type="text" name="color" value="{{ old('color') }}"
                        class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                        placeholder="Ví dụ: Trắng, Đen, Đỏ...">
                </div>
            </div>
        </div>

        {{-- THÔNG SỐ KỸ THUẬT --}}
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                    <i class="fas fa-cogs text-orange-500"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Thông số kỹ thuật</h3>
                    <p class="text-xs text-gray-400">Động cơ, hộp số và sức chứa</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nhiên liệu</label>
                    <select name="fuel_type" class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        <option value="">-- Chọn --</option>
                        @foreach(['Xăng','Dầu','Điện','Hybrid','Plug-in Hybrid'] as $f)
                            <option value="{{ $f }}" @selected(old('fuel_type') == $f)>{{ $f }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Hộp số</label>
                    <select name="transmission" class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        <option value="">-- Chọn --</option>
                        @foreach(['Tự động','Sàn','CVT','DCT'] as $tr)
                            <option value="{{ $tr }}" @selected(old('transmission') == $tr)>{{ $tr }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Dung tích động cơ</label>
                    <input type="text" name="engine_capacity" value="{{ old('engine_capacity') }}"
                        class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                        placeholder="Ví dụ: 2.0L, 1.5T...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Số chỗ ngồi</label>
                    <select name="seats" class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        <option value="">-- Chọn --</option>
                        @foreach([2,4,5,7,8,9] as $s)
                            <option value="{{ $s }}" @selected(old('seats') == $s)>{{ $s }} chỗ</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- ẢNH & MÔ TẢ --}}
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-image text-purple-500"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Ảnh & mô tả</h3>
                    <p class="text-xs text-gray-400">Hình ảnh đại diện và thông tin chi tiết</p>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ảnh đại diện của xe</label>
                    <label for="featured_image" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-200 rounded-xl py-8 cursor-pointer hover:border-blue-400 hover:bg-blue-50/40 transition-colors group">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 group-hover:text-blue-400 mb-2 transition-colors"></i>
                        <span class="text-sm text-gray-500"><span class="text-blue-600 font-semibold">Bấm để chọn ảnh</span> hoặc kéo thả vào đây</span>
                        <span class="text-xs text-gray-400 mt-1">PNG, JPG tối đa 5MB</span>
                        <input id="featured_image" type="file" name="featured_image" accept="image/*" class="hidden">
                    </label>
                    <p id="file-name" class="text-xs text-gray-500 mt-2 hidden"><i class="fas fa-paperclip mr-1"></i><span></span></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Mô tả chi tiết</label>
                    <textarea name="description" rows="4"
                        class="w-full rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                        placeholder="Nhập thông số kỹ thuật hoặc giới thiệu xe...">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- TRẠNG THÁI --}}
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-6 md:p-8">
            <label for="status" class="flex items-center justify-between cursor-pointer">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kích hoạt mở bán ngay lập tức</p>
                    <p class="text-xs text-gray-400 mt-0.5">Xe sẽ hiển thị công khai cho khách hàng sau khi lưu</p>
                </div>
                <div class="relative">
                    <input type="checkbox" name="status" id="status" value="1" checked class="sr-only peer">
                    <div class="w-12 h-6 bg-gray-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-6"></div>
                </div>
            </label>
        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-3 pb-6">
            <a href="{{ route('admin.cars.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                Hủy bỏ
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm hover:shadow transition-all">
                <i class="fas fa-save"></i> Lưu lại
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('featured_image').addEventListener('change', function(e) {
        const nameEl = document.getElementById('file-name');
        if (e.target.files.length > 0) {
            nameEl.classList.remove('hidden');
            nameEl.querySelector('span').textContent = e.target.files[0].name;
        } else {
            nameEl.classList.add('hidden');
        }
    });
</script>
@endsection