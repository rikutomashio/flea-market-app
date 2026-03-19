<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品詳細ページに必要な情報が表示される()
    {
        $user = User::factory()->create();

        $product = Product::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'condition' => 1,
            'description' => 'テスト説明',
            'price' => 1000,
            'is_sold' => false,
            'image_path' => 'test.jpg',
        ]);

        $category = Category::create([
            'name' => 'ファッション'
        ]);

        $product->categories()->attach($category->id);

        $response = $this->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('1,000');
        $response->assertSee('テスト説明');
        $response->assertSee('ファッション');
    }

    /** @test */
    public function 複数選択されたカテゴリが表示されている()
    {
        $user = User::factory()->create();

        $product = Product::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'condition' => 1,
            'description' => 'テスト説明',
            'price' => 1000,
            'is_sold' => false,
            'image_path' => 'test.jpg',
        ]);

        $category1 = Category::create(['name' => 'ファッション']);
        $category2 = Category::create(['name' => 'メンズ']);

        $product->categories()->attach([
            $category1->id,
            $category2->id
        ]);

        $response = $this->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}