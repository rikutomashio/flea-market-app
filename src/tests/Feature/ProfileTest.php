<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase; // ← これ追加
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ユーザーはプロフィールページを表示できる()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/mypage');

        $response->assertStatus(200);
    }

    /** @test */
    public function プロフィールページにユーザー名が表示される()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー'
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage');

        $response->assertSee('テストユーザー');
    }

    /** @test */
    public function プロフィールページに出品商品が表示される()
    {
        $user = User::factory()->create();

        Product::factory()->create([
            'user_id' => $user->id,
            'name' => 'テスト商品'
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage?page=sell');

        $response->assertSee('テスト商品');
    }

    /** @test */
    public function プロフィールページに購入商品が表示される()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'name' => 'テスト商品'
        ]);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }
}