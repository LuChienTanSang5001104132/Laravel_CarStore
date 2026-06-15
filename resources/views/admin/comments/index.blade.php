@extends('layouts.app')

@section('title', 'Quản Lý Bình Luận')
@section('header', 'Danh Sách Đánh Giá')

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
                <span class="text-blue-600">Quản lý bình luận</span>
            </div>

            <h2 class="text-2xl font-bold text-gray-800">Quản Lý Bình Luận & Đánh Giá</h2>
            <p class="text-sm text-gray-500 mt-1">Xem và kiểm duyệt các phản hồi từ khách hàng về các dòng xe.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <form action="{{ route('admin.comments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" name="search" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tìm theo nội dung bình luận..." value="{{ request('search') }}">
            </div>
            <div>
                <select name="rating" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Lọc theo số sao --</option>
                    <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>5 Sao ⭐⭐⭐⭐⭐</option>
                    <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>4 Sao ⭐⭐⭐⭐</option>
                    <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>3 Sao ⭐⭐⭐</option>
                    <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>2 Sao ⭐⭐</option>
                    <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>1 Sao ⭐</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-xl px-4 py-2 transition-colors w-full md:w-auto">
                    <i class="fas fa-filter mr-1"></i> Lọc kết quả
                </button>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-xl text-green-700 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm font-semibold">
                        <th class="p-4">ID</th>
                        <th class="p-4">Khách Hàng</th>
                        <th class="p-4">Xe Được Đánh Giá</th>
                        <th class="p-4">Đánh Giá</th>
                        <th class="p-4">Nội Dung</th>
                        <th class="p-4">Ngày Đăng</th>
                        <th class="p-4 text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 text-gray-500">#{{ $review->id }}</td>
                        <td class="p-4">
                            <p class="font-bold text-gray-900">{{ $review->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $review->user->email ?? '' }}</p>
                        </td>
                        <td class="p-4 font-semibold text-blue-600">
                            {{ $review->car->name ?? 'Xe đã bị xóa' }}
                        </td>
                        <td class="p-4 text-yellow-500 font-bold">
                            {{ str_repeat('⭐', $review->rating ?? 5) }}
                        </td>
                        <td class="p-4 text-gray-700 max-w-xs truncate" title="{{ $review->content }}">
                            {{ $review->content }}
                        </td>
                        <td class="p-4 text-gray-500">{{ $review->created_at->format('d/m/Y') }}</td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Nút duyệt (chỉ hiện nếu chưa duyệt) --}}
                                @if(!$review->is_approved)
                                    <form action="{{ route('admin.comments.approve', $review->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 font-semibold bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                            <i class="fas fa-check-circle mr-1"></i> Duyệt
                                        </button>
                                    </form>
                                @endif

                                {{-- Nút xóa --}}
                                <form action="{{ route('admin.comments.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors text-xs">
                                        <i class="fas fa-trash mr-1"></i> Xóa / Gỡ bỏ
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400">Chưa có bình luận hoặc đánh giá nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
</div>
@endsection