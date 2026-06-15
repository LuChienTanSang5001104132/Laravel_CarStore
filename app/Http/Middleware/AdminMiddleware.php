<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // FIXED: Kiểm tra auth() trước, nếu chưa đăng nhập trả 401
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chưa đăng nhập.'
            ], 401);
        }

        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền truy cập trang quản trị.'
            ], 403);
        }

        return $next($request);
    }
}
