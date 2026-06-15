<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Car;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::pluck('id')->toArray();
        $cars = Car::pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            Comment::create([
                'user_id' => $faker->randomElement($users),
                'car_id' => $faker->optional(0.7)->randomElement($cars), // 70% có car_id
                'content' => $faker->sentence(rand(10, 25)),
                'rating' => rand(3, 5),
                'is_approved' => $i < 15 ? true : false, // 15 comment duyệt, 5 chưa duyệt
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
            ]);
        }
    }
}