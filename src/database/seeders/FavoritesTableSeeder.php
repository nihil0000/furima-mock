<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Product;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();

        // Generate 30 random unique combinations from users and products
        $combinations = collect($users)
            ->crossJoin($products)
            ->shuffle()
            ->take(30);

        foreach ($combinations as [$user_id, $product_id]) {
            Favorite::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
            ]);
        }
    }
}
