<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminTestDriveController;

// ==================== GIAO DIỆN FRONTEND ====================
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/home', function () { return view('home'); });
Route::get('/ThongTin', function () { return view('thongtin'); }); 
Route::get('/ChiTietXe/{id}', function ($id) { return view('typecars.chitietxe', ['id' => $id]); }); 
Route::get('/TimKiem', function () { return view('timkiem'); });
Route::get('/mauxe', function () { return view('typecars.mauxe'); })->name('mauxe');

// Auth views
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.forgot');

// Các trang khách hàng
Route::get('/cart', function () { return view('cart'); })->name('cart');
Route::get('/checkout', function () { return view('checkout'); })->name('checkout');
Route::get('/profile', function () { return view('profile'); })->name('profile');
Route::get('/orders', function () { return view('orders'); })->name('orders');

// Trang thông tin tĩnh
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/warranty-policy', function () { return view('warranty_policy'); })->name('warranty');
Route::get('/installment', function () { return view('installment'); })->name('installment');


// ==================== KHU VỰC QUẢN TRỊ ADMIN ====================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // ĐÃ SỬA: Trỏ trực tiếp đến AdminController thay vì dùng function()
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Quản lý Xe
    Route::get('/cars', [AdminCarController::class, 'index'])->name('cars.index');
    Route::get('/cars/create', [AdminCarController::class, 'create'])->name('cars.create');
    Route::post('/cars/store', [AdminCarController::class, 'store'])->name('cars.store');
    Route::get('/cars/{id}', [AdminCarController::class, 'show'])->name('cars.show');
    Route::get('/cars/{id}/edit', [AdminCarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{id}/update', [AdminCarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{id}/destroy', [AdminCarController::class, 'destroy'])->name('cars.destroy');

    // Quản lý Người dùng
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}/update', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}/destroy', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Quản lý Đơn hàng
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}/destroy', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Quản lý Bình luận
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/{id}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::get('/comments/{id}/edit', [AdminCommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [AdminCommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    // Quản lý Đăng ký lái thử
    Route::get('/test-drives', [AdminTestDriveController::class, 'index'])->name('test-drives.index');
    Route::get('/test-drives/{id}/edit', [AdminTestDriveController::class, 'edit'])->name('test-drives.edit');
    Route::put('/test-drives/{id}', [AdminTestDriveController::class, 'update'])->name('test-drives.update');
    Route::delete('/test-drives/{id}', [AdminTestDriveController::class, 'destroy'])->name('test-drives.destroy');

    // Báo cáo & Thống kê
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
    Route::get('/reports/export-pdf', [AdminReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/export-excel', [AdminReportController::class, 'exportExcel'])->name('reports.excel');
});