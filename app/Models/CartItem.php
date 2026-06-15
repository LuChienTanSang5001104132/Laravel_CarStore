<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    // Cho phép gán dữ liệu hàng loạt cho các trường này
    protected $fillable = [
        'user_id', 
        'car_id', 
        'quantity', 
        'price'
    ];

    /**
     * Mối quan hệ: Mỗi CartItem thuộc về một chiếc xe cụ thể
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Mối quan hệ: Mỗi CartItem thuộc về một người dùng
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}