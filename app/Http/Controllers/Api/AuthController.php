<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * XỬ LÝ ĐĂNG KÝ (REGISTER)
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Dữ liệu không hợp lệ',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Đăng ký tài khoản thành công! Vui lòng đăng nhập.',
        ], 201);
    }

    /**
     * XỬ LÝ ĐĂNG NHẬP (LOGIN)
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email hoặc mật khẩu không chính xác'
            ], 401);
        }

        $token = $user->createToken('CarStoreAuthToken')->plainTextToken;

        return response()->json([
            'status'       => 'success',
            'message'      => 'Đăng nhập thành công',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role
            ]
        ], 200);
    }

    /**
     * XỬ LÝ ĐĂNG XUẤT (LOGOUT)
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Đăng xuất thành công'
        ], 200);
    }

    /**
     * XEM THÔNG TIN HỒ SƠ (PROFILE)
     */
    public function profile(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $request->user()
        ], 200);
    }

    /**
     * CẬP NHẬT HỒ SƠ & ĐỔI ẢNH (UPDATE PROFILE)
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
            'birth'     => 'nullable|date',
            'avatar'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Cập nhật các trường dữ liệu text
        $data = $request->only(['full_name', 'phone', 'address', 'birth']);

        // Xử lý logic lưu ảnh Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Cập nhật hồ sơ thành công',
            'data'    => $user
        ], 200);
    }

    /**
     * QUÊN MẬT KHẨU
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email này chưa được đăng ký trong hệ thống.'
        ]);

        $code = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $code, 'created_at' => now()]
        );

        Mail::raw("Xin chào,\n\nMã xác nhận khôi phục mật khẩu của bạn là: $code\n\nVui lòng không chia sẻ mã này cho bất kỳ ai.", function ($message) use ($request) {
            $message->to($request->email)->subject('Mã xác nhận khôi phục mật khẩu - CarStore');
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Mã xác nhận đã được gửi vào email của bạn.'
        ], 200);
    }

    /**
     * ĐẶT LẠI MẬT KHẨU
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'code'     => 'required|numeric',
            'password' => 'required|min:6|confirmed'
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Mã xác nhận không chính xác hoặc đã hết hạn.'
            ], 400);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Tuyệt vời! Bạn đã đổi mật khẩu thành công.'
        ], 200);
    }

    /**
     * ĐỔI MẬT KHẨU
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Mật khẩu hiện tại không chính xác.'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Đổi mật khẩu thành công!'
        ], 200);
    }
}