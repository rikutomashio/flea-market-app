<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class FavoriteListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function favorite_items_are_displayed()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'name' => 'テスト商品'
        ]);

        $user->favorites()->attach($product->id);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('テスト商品');
    }

    /** @test */
    public function sold_items_show_sold_label()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'name' => '売り切れ商品',
            'is_sold' => true
        ]);

        $user->favorites()->attach($product->id);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('SOLD');
    }

    /** @test */
    public function guest_can_access_mylist_page()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
    }
}