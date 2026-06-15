<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'car_id',
        'rating',
        'content',
        'is_approved',  // THÊM DÒNG NÀY
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean', // tùy chọn, để chuyển đổi đúng kiểu
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}