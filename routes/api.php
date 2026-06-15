<?php

use Illuminate\Support\Facades\Route;

// Lớp Controller API User (Gộp thư viện cho gọn)
use App\Http\Controllers\Api\{AuthController, CartController, CarApiController, ReviewController, OrderController, ChatbotController};

// Lớp Controller API Admin (Gộp thư viện cho gọn)
use App\Http\Controllers\Admin\{AdminController, AdminCarController, AdminUserController, AdminOrderController, AdminCommentController, AdminReportController};
use App\Http\Controllers\Api\TestDriveController;
/*
|--------------------------------------------------------------------------
| API ROUTES - KHÁCH HÀNG (CLIENT)
|--------------------------------------------------------------------------
*/

// 1. Auth & Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Route xử lý Chatbot AI (Public)
Route::post('/chatbot', [ChatbotController::class, 'chat']);
Route::post('/test-drive', [TestDriveController::class, 'store']);
// Public Cars, Brands & Reviews
Route::get('/cars', [CarApiController::class, 'index']);
Route::get('/cars/{id}', [CarApiController::class, 'show']);
Route::get('/cars/{carId}/reviews', [ReviewController::class, 'index']);
Route::post('/cars/{carId}/reviews', [ReviewController::class, 'store'])->middleware('auth:sanctum');
// API Lấy danh sách Hãng xe đổ vào Bộ lọc (Bổ sung để fix lỗi 404)
Route::get('/brands', function () {
    return response()->json([
        'success' => true,
        'data'    => \App\Models\Brand::all()
    ]);
});

// 2. Protected (Yêu cầu Token)
Route::middleware('auth:sanctum')->group(function () {
    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
    
    // Giỏ hàng (Dùng apiResource chuẩn RESTful)
    Route::apiResource('cart', CartController::class);

    // Orders
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::post('/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment']);

    // Reviews
    Route::post('/cars/{carId}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| API ROUTES - QUẢN TRỊ (ADMIN)
|--------------------------------------------------------------------------
*/
// Lưu ý: Đảm bảo user có role 'admin' để truy cập nhóm này
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard & Báo cáo
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/reports', [AdminReportController::class, 'index']);
    Route::get('/reports/export-pdf', [AdminReportController::class, 'exportPdf']);
    Route::get('/reports/export-excel', [AdminReportController::class, 'exportExcel']);

    // Quản lý User và Xe (Tự động map các route chuẩn: index, store, show, update, destroy)
    Route::apiResource('users', AdminUserController::class);
    Route::apiResource('cars', AdminCarController::class);

    // Đơn hàng (Admin)
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
    Route::put('/orders/{id}/payment', [AdminOrderController::class, 'updatePaymentStatus']);
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy']);

    // Bình luận
    Route::get('/comments', [AdminCommentController::class, 'index']);
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy']);
});