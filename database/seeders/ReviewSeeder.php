<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Car;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::pluck('id')->toArray();
        $cars = Car::pluck('id')->toArray();

        // 1. Bình luận gắn với xe cụ thể (20 bình luận)
        for ($i = 0; $i < 20; $i++) {
            Review::create([
                'user_id'     => $faker->randomElement($users),
                'car_id'      => $faker->randomElement($cars),
                'content'     => $faker->sentence(rand(10, 20)),
                'rating'      => rand(3, 5),
                'is_approved' => true,
                'created_at'  => $faker->dateTimeBetween('-3 months', 'now'),
            ]);
        }

        // 2. Bình luận chưa duyệt (3 bình luận, cũng có car_id)
        for ($i = 0; $i < 3; $i++) {
            Review::create([
                'user_id'     => $faker->randomElement($users),
                'car_id'      => $faker->randomElement($cars),
                'content'     => $faker->sentence(rand(10, 18)),
                'rating'      => rand(2, 4),
                'is_approved' => false,
                'created_at'  => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
        }
    }
}