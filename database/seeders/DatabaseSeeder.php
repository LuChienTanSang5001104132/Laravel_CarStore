<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo tài khoản Admin ngay tại đây (hoặc bạn có thể tạo UserSeeder riêng cũng được)
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin123456789'), 
            'role'     => 'admin', 
        ]);

        // 2. Gọi các file Seeder riêng biệt chạy
        $this->call([
            BrandSeeder::class,
            // Sau này bạn có thêm xe thì sẽ gọi CarSeeder::class ở đây...
        ]);
    }
}