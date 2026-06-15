<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Các trường cho phép thêm/sửa dữ liệu hàng loạt (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',         // Phân quyền (admin/user)
        'full_name',    // Tên đầy đủ
        'phone',        // Số điện thoại
        'address',      // Địa chỉ
        'birth',        // Ngày sinh
        'avatar',       // Ảnh đại diện
    ];

    /**
     * Các trường cần được ẩn đi khi trả về JSON (bảo mật)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu dữ liệu (Casts)
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'birth'             => 'date', // Ép kiểu cột birth thành ngày tháng
        ];
    }

    // ── CÁC MỐI QUAN HỆ (RELATIONSHIPS) CỦA ĐỒ ÁN ──

    // Một người dùng có nhiều Đơn hàng
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Một người dùng có nhiều Sản phẩm trong giỏ hàng
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Một người dùng có nhiều Lượt đánh giá xe
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ── CÁC HÀM HỖ TRỢ KIỂM TRA QUYỀN (HELPERS) ──

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}