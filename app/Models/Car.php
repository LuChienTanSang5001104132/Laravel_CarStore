<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Car extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'price',
        'year',
        'color',
        'type',
        'quantity',
        'mileage',
        'fuel_type',
        'transmission',
        'engine_capacity',
        'seats',
        'description',
        'featured_image',
        'status',
        'views',
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'status'   => 'boolean',
        'quantity' => 'integer',
        'year'     => 'integer',
        'views'    => 'integer',
        'seats'    => 'integer',
        'mileage'  => 'integer',
    ];

    // Tự động tạo slug nếu chưa có
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($car) {
            if (empty($car->slug)) {
                $car->slug = Str::slug($car->name) . '-' . uniqid();
            }
        });
    }
    
    // Tự động nhận diện đường dẫn ảnh (Từ Seeder hoặc Upload)
    public function getImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('Image/' . $this->name . '.jpg');
    }

    // Relationships
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class); // Thêm: quan hệ với giỏ hàng
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}