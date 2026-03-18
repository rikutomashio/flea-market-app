<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'condition' => 'good',
            'description' => 'テスト商品説明',
            'price' => 1000,
            'is_sold' => false,
            'image_path' => 'test.jpg',
        ];
    }
}
