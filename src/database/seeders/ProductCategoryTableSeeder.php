<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        $categories = Category::all();

        foreach ($products as $product) {
            DB::table('product_category')->insert([
                'product_id' => $product->id,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
