<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'product_name' => '腕時計',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'status' => '良好',
            'image' => 'images/clock.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 2,
            'product_name' => 'HDD',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク',
            'status' => '目立った傷や汚れなし',
            'image' => 'images/hdd.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 3,
            'product_name' => '玉ねぎ3束',
            'price' => 300,
            'description' => '新鮮な玉ねぎ3束のセット',
            'status' => 'やや傷や汚れあり',
            'image' => 'images/onion.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 4,
            'product_name' => '革靴',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'status' => '状態が悪い',
            'image' => 'images/leather_shoes.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 5,
            'product_name' => 'ノートPC',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'status' => '良好',
            'image' => 'images/laptop.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 6,
            'product_name' => 'マイク',
            'price' => 8000,
            'description' => '高音質のレコーディング用マイク',
            'status' => '目立った傷や汚れなし',
            'image' => 'images/microphone.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 7,
            'product_name' => 'ショルダーバッグ',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'status' => 'やや傷や汚れあり',
            'image' => 'images/bag.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 8,
            'product_name' => 'タンブラー',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'status' => '状態が悪い',
            'image' => 'images/tumbler.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 9,
            'product_name' => 'コーヒーミル',
            'price' => 4000,
            'description' => '手動のコーヒーミル',
            'status' => '良好',
            'image' => 'images/coffee_grinder.jpg',
        ];
        DB::table('products')->insert($param);

        $param = [
            'user_id' => 10,
            'product_name' => 'メイクセット',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'status' => '目立った傷や汚れなし',
            'image' => 'images/makeup_set.jpg',
        ];
        DB::table('products')->insert($param);
    }
}
