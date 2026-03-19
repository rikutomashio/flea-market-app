<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ユーザーは商品を出品できる()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'テスト商品の説明',
            'condition' => 1,
            'category_ids' => [$category->id],
            'image' => UploadedFile::fake()->create('test.jpg')
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'テスト商品の説明',
            'user_id' => $user->id
        ]);

        $product = Product::first();

        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $category->id
        ]);
    }
}