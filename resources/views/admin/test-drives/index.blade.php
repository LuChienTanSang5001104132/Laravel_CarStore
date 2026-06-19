@extends('admin.layout.app')

@section('title', 'Quản lý Lái thử')
@section('header', 'Danh sách đăng ký lái thử')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Đăng ký lái thử</h2>
            <p class="text-sm text-gray-500 mt-1">Quản lý các yêu cầu lái thử từ khách hàng.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-xl text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên, SĐT, email..." class="rounded-xl border-gray-200 bg-gray-50 text-sm px-4 py-2 focus:border-blue-500 focus:ring-blue-500">
            <select name="status" class="rounded-xl border-gray-200 bg-gray-50 text-sm px-4 py-2 focus:border-blue-500 focus:ring-blue-500">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Đã liên hệ</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-semibold">Lọc</button>
                <a href="{{ route('admin.test-drives.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-xl text-sm font-semibold">Xóa lọc</a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm font-semibold">
                        <th class="p-4">ID</th>
                        <th class="p-4">Họ tên</th>
                        <th class="p-4">SĐT</th>
                        <th class="p-4">Xe muốn lái</th>
                        <th class="p-4">Ngày dự kiến</th>
                        <th class="p-4">Trạng thái</th>
                        <th class="p-4 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($testDrives as $drive)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 text-gray-500">#{{ $drive->id }}</td>
                        <td class="p-4 font-bold text-gray-900">{{ $drive->full_name }}</td>
                        <td class="p-4">{{ $drive->phone }}</td>
                        <td class="p-4">{{ $drive->car->name ?? 'Không xác định' }}</td>
                        <td class="p-4">{{ $drive->preferred_date ?? 'Chưa đặt' }}</td>
                        <td class="p-4">
                            @php
                                $statuses = [
                                    'pending'   => ['Chờ xử lý', 'bg-yellow-100 text-yellow-800'],
                                    'contacted' => ['Đã liên hệ', 'bg-blue-100 text-blue-800'],
                                    'completed' => ['Hoàn thành', 'bg-green-100 text-green-800'],
                                    'cancelled' => ['Đã hủy', 'bg-red-100 text-red-800'],
                                ];
                                $st = $statuses[$drive->status] ?? ['Không xác định', 'bg-gray-100 text-gray-800'];
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $st[1] }}">{{ $st[0] }}</span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.test-drives.edit', $drive->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors">
                                    <i class="fas fa-edit mr-1"></i> Sửa
                                </a>
                                <form action="{{ route('admin.test-drives.destroy', $drive->id) }}" method="POST" onsubmit="return confirm('Xóa đăng ký lái thử này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors">
                                        <i class="fas fa-trash mr-1"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400">Chưa có đăng ký lái thử nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $testDrives->appends(request()->query())->links() }}
    </div>
</div>
@endsection