@extends('layouts.app')

@section('title', 'Quản Lý Người Dùng')
@section('header', 'Danh Sách Thành Viên')

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
                <span class="text-blue-600">Quản lý người dùng</span>
            </div>

            <h2 class="text-2xl font-bold text-gray-800">Quản Lý Người Dùng</h2>
            <p class="text-sm text-gray-500 mt-1">Xem, tìm kiếm và điều chỉnh danh sách thành viên trong hệ thống.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
            <i class="fas fa-plus mr-2"></i> Thêm Người Dùng
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <input type="text" name="search" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tìm theo tên hoặc email..." value="{{ request('search') }}">
            </div>
            <div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-xl px-4 py-2 transition-colors">
                    <i class="fas fa-search mr-1"></i> Tìm kiếm
                </button>
            </div>
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
                        <th class="p-4">ID</th>
                        <th class="p-4">Tên</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Vai Trò</th>
                        <th class="p-4">Ngày Đăng Ký</th>
                        <th class="p-4 text-center">Hành Động</th> 
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4">{{ $user->id }}</td>
                        <td class="p-4 font-bold text-gray-900">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            @if($user->role === 'admin')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Admin</span>
                            @else
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Khách hàng</span>
                            @endif
                        </td>
                        <td class="p-4">{{ $user->created_at->format('d/m/Y') }}</td>
                        
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Nút Chi Tiết --}}
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-gray-600 hover:text-gray-900 font-semibold bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                    <i class="fas fa-eye mr-1"></i> Chi Tiết
                                </a>

                                {{-- Nút Sửa --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                    <i class="fas fa-edit mr-1"></i> Sửa
                                </a>

                                {{-- Nút Xóa --}}
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                        <i class="fas fa-trash mr-1"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">Không tìm thấy người dùng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection