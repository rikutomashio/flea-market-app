<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品一覧ページが表示される()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function 商品が表示される()
{
    $user = User::factory()->create();

    Product::create([
        'user_id' => $user->id,
        'name' => 'テスト商品',
        'brand' => 'テストブランド',
        'condition' => '良好',
        'description' => 'テスト説明',
        'price' => 1000,
        'is_sold' => false,
        'image_path' => 'test.jpg',
    ]);

    $response = $this->get('/');

    $response->assertSee('テスト商品');
}

    /** @test */
public function 購入済み商品はSoldと表示される()
{
    $user = User::factory()->create();

    Product::create([
        'user_id' => $user->id,
        'name' => '売り切れ商品',
        'brand' => 'テストブランド',
        'condition' => '良好',
        'description' => 'テスト説明',
        'price' => 1000,
        'is_sold' => true,
        'image_path' => 'test.jpg',
    ]);

    $response = $this->get('/');

    $response->assertSee('SOLD');
}
    /** @test */
public function 自分が出品した商品は表示されない()
{
    $user = User::factory()->create();

    Product::create([
        'user_id' => $user->id,
        'name' => '自分の商品',
        'brand' => 'テストブランド',
        'condition' => '良好',
        'description' => '説明',
        'price' => 1000,
        'is_sold' => false,
        'image_path' => 'test.jpg',
    ]);

    $response = $this->actingAs($user)->get('/');

    $response->assertDontSee('自分の商品');
}
}