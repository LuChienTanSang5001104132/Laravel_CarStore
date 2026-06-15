@extends('layouts.app')

@section('title', 'Cập Nhật Người Dùng')
@section('header', 'Chỉnh Sửa Thông Tin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline flex items-center text-sm font-semibold">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Chỉnh sửa tài khoản: <span class="text-blue-600">{{ $user->name }}</span></h2>
        
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và Tên</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
                    <input type="password" name="password" id="password" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Bỏ trống nếu không đổi mật khẩu">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Phân quyền (Vai trò)</label>
                    <select name="role" id="role" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Khách hàng</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow transition-colors">
                    <i class="fas fa-check mr-2"></i> Cập Nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection