<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名で部分一致検索ができる()
    {
        $user = User::factory()->create();

        Product::create([
            'user_id' => $user->id,
            'name' => '赤いバッグ',
            'brand' => 'ブランドA',
            'condition' => '良好',
            'description' => '説明',
            'price' => 1000,
            'is_sold' => false,
            'image_path' => 'test.jpg',
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => '青い靴',
            'brand' => 'ブランドB',
            'condition' => '良好',
            'description' => '説明',
            'price' => 2000,
            'is_sold' => false,
            'image_path' => 'test.jpg',
        ]);

        $response = $this->get('/?keyword=バッグ');

        $response->assertSee('赤いバッグ');
        $response->assertDontSee('青い靴');
    }

    /** @test */
    public function 検索状態がマイリストでも保持されている()
    {
        $response = $this->get('/?keyword=バッグ&tab=mylist');

        $response->assertSee('value="バッグ"', false);
    }
}
