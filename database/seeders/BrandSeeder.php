<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand; // Nhớ gọi Model Brand

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brandNames = ['Toyota', 'Honda', 'Ford', 'BMW', 'VinFast'];
        
        foreach ($brandNames as $name) {
            Brand::create([
                'name' => $name,
            ]);
        }
    }
}