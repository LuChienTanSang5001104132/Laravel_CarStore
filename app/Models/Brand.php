<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // Các trường cho phép thêm dữ liệu
    protected $fillable = ['name']; 
    
    // Khai báo mối quan hệ: Một hãng xe (Brand) có nhiều xe (Car)
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}