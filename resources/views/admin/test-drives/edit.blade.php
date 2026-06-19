@extends('admin.layout.app')

@section('title', 'Sửa đăng ký lái thử')
@section('header', 'Sửa đăng ký lái thử #' . $testDrive->id)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('admin.test-drives.update', $testDrive->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Họ tên *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $testDrive->full_name) }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                    <input type="text" name="phone" value="{{ old('phone', $testDrive->phone) }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $testDrive->email) }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Xe muốn lái thử</label>
                <select name="car_id" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Chọn xe (nếu có) --</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ $testDrive->car_id == $car->id ? 'selected' : '' }}>
                            {{ $car->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ngày dự kiến</label>
                <input type="date" name="preferred_date" value="{{ old('preferred_date', $testDrive->preferred_date) }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lời nhắn</label>
                <textarea name="message" rows="3" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:border-blue-500 focus:ring-blue-500">{{ old('message', $testDrive->message) }}</textarea>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <select name="status" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:border-blue-500 focus:ring-blue-500">
                    <option value="pending" {{ $testDrive->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="contacted" {{ $testDrive->status == 'contacted' ? 'selected' : '' }}>Đã liên hệ</option>
                    <option value="completed" {{ $testDrive->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="cancelled" {{ $testDrive->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.test-drives.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-semibold">Hủy</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
@endsection