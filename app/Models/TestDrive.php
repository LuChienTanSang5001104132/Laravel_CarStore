<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestDrive extends Model
{
    use HasFactory;

    /**
     * Các trường được phép gán hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'car_id',
        'preferred_date',
        'message',
        'status'
    ];

    /**
     * Các trường cần chuyển đổi kiểu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preferred_date' => 'date',
    ];

    /**
     * Quan hệ với Car: một đăng ký lái thử có thể thuộc về một xe.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // --- Các hằng số trạng thái ---
    const STATUS_PENDING   = 'pending';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Lấy danh sách các trạng thái kèm nhãn hiển thị.
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING   => 'Chờ xử lý',
            self::STATUS_CONTACTED => 'Đã liên hệ',
            self::STATUS_COMPLETED => 'Hoàn thành',
            self::STATUS_CANCELLED => 'Đã hủy',
        ];
    }

    /**
     * Scope lọc theo trạng thái.
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}