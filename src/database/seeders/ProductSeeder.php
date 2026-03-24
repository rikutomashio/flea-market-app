<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $products = [
            [
                'user_id' => 1,
                'category_ids' => [1],
                'name' => '腕時計',
                'description' => 'ブランド：Rolax。スタイリッシュなデザインのメンズ腕時計。',
                'price' => 15000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'brand' => 'Rolax',
                'condition' => 1,
                'is_sold' => 0,
            ],
            [
                'user_id' => 1,
                'category_ids' => [2], // 家電・電子機器
                'name' => 'HDD',
                'description' => 'ブランド：西芝。高速で信頼性の高いハードディスク。コンディション：目立った傷や汚れなし。',
                'price' => 5000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'brand' => '西芝',
                'condition' => 1,
                'is_sold' => 0,
            ],
            [
                'user_id' => 1,
                'category_ids' => [4], // 食品
                'name' => '玉ねぎ3束',
                'description' => 'ブランド：なし。新鮮な玉ねぎ3束のセット。コンディション：やや傷や汚れあり。',
                'price' => 300,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'brand' => 'なし',
                'condition' => 2,
                'is_sold' => 0,
            ],
            [
                'user_id' => 1,
                'category_ids' => [1], // ファッション
                'name' => '革靴',
                'description' => 'クラシックなデザインの革靴。コンディション：状態が悪い。',
                'price' => 4000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'brand' => 'なし',
                'condition' => 3,
                'is_sold' => 0,
            ],
            [
                'user_id' => 2,
                'category_ids' => [2], // 家電・電子機器
                'name' => 'ノートPC',
                'description' => '高性能なノートパソコン。コンディション：良好。',
                'price' => 45000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'brand' => 'なし',
                'condition' => 1,
                'is_sold' => 0,
            ],
            [
                'user_id' => 2,
                'category_ids' => [2], // 家電・電子機器
                'name' => 'マイク',
                'description' => 'ブランド：なし。高音質のレコーディング用マイク。コンディション：目立った傷や汚れなし。',
                'price' => 8000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'brand' => 'なし',
                'condition' => 1,
                'is_sold' => 0,
            ],
            [
                'user_id' => 2,
                'category_ids' => [1], // ファッション
                'name' => 'ショルダーバッグ',
                'description' => 'おしゃれなショルダーバッグ。コンディション：やや傷や汚れあり。',
                'price' => 3500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'brand' => 'なし',
                'condition' => 2,
                'is_sold' => 0,
            ],
            [
                'user_id' => 2,
                'category_ids' => [3], // 生活雑貨
                'name' => 'タンブラー',
                'description' => 'ブランド：なし。使いやすいタンブラー。コンディション：状態が悪い。',
                'price' => 500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'brand' => 'なし',
                'condition' => 3,
                'is_sold' => 0,
            ],
            [
                'user_id' => 2,
                'category_ids' => [3],
                'name' => 'コーヒーミル',
                'description' => 'ブランド：Starbacks。手動のコーヒーミル。コンディション：良好。',
                'price' => 4000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'brand' => 'Starbacks',
                'condition' => 1,
                'is_sold' => 0,
            ],
            [
                'user_id' => 2,
                'category_ids' => [5],
                'name' => 'メイクセット',
                'description' => '便利なメイクアップセット。コンディション：目立った傷や汚れなし。',
                'price' => 2500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'brand' => 'なし',
                'condition' => 1,
                'is_sold' => 0,
            ],
        ];

        foreach ($products as $data) {

            $categoryIds = $data['category_ids'];
            unset($data['category_ids']);

            $product = Product::create($data);

            $product->categories()->attach($categoryIds);
        }
    }
}
