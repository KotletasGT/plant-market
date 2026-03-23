<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $products = Product::all();

        foreach (range(1, 100) as $i) {
            Review::create([
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => rand(1, 5),
                'comment' => fake()->sentence(),
            ]);
        }
    }
}
