<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // ── 1. LẤY DANH SÁCH NGƯỜI DÙNG ──
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate($request->get('per_page', 15));

        // Nếu gọi từ API (Thầy chấm điểm Postman)
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $users
            ]);
        }

        // Nếu gọi từ Giao diện Web (Blade)
        return view('admin.users.index', compact('users'));
    }

    // ── 2. XEM CHI TIẾT 1 NGƯỜI DÙNG ──
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $user
            ]);
        }

        return view('admin.users.show', compact('user'));
    }

    // BỔ SUNG
    // ── HIỂN THỊ FORM THÊM NGƯỜI DÙNG ──
    public function create()
    {
        return view('admin.users.create');
    }

    // ── HIỂN THỊ FORM SỬA NGƯỜI DÙNG ──
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // ── 3. THÊM NGƯỜI DÙNG MỚI ──
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:user,admin',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
            'role'     => $request->role,
        ]);

        // API
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thêm người dùng thành công',
                'data'    => $user
            ], 201); // 201 Created chuẩn RESTful
        }

        // Web
        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công!');
    }

    // ── 4. CẬP NHẬT THÔNG TIN NGƯỜI DÙNG ──
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => ['sometimes', 'email', Rule::unique('users')->ignore($id)],
            'role'     => 'sometimes|in:user,admin',
            'password' => 'nullable|string|min:6',
        ]);

        // Lấy tất cả các trường có thể cập nhật
        $data = $request->only(['name', 'email', 'role', 'phone', 'address', 'full_name', 'birth']);

        // Chỉ mã hóa nếu có nhập mật khẩu mới
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // API
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật người dùng thành công',
                'data'    => $user->fresh()
            ]);
        }

        // Web
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    // ── 5. XÓA NGƯỜI DÙNG ──
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Chặn tự xóa chính mình
        if ($user->id === auth()->id()) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Không thể xóa tài khoản đang đăng nhập'], 403);
            }
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa tài khoản đang đăng nhập!');
        }

        // Chặn xóa admin khác
        if ($user->role === 'admin') {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Không thể xóa tài khoản Quản trị viên'], 403);
            }
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa tài khoản Quản trị viên!');
        }

        $user->delete();

        // API
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa người dùng thành công'
            ]);
        }

        // Web
        return redirect()->route('admin.users.index')->with('success', 'Đã xóa người dùng thành công!');
    }
}