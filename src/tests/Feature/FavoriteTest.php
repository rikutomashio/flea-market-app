<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_favorite_product()
{
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)
        ->post("/products/{$product->id}/favorite");

    $response->assertStatus(302);

    $this->assertDatabaseHas('favorites', [
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);
}
    public function test_user_can_unfavorite_product()
{
    $user = User::factory()->create();
    $product = Product::factory()->create();

    Favorite::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);

    $response = $this->actingAs($user)
        ->post("/products/{$product->id}/favorite");

    $response->assertStatus(302);

    $this->assertDatabaseMissing('favorites', [
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);
}
    public function test_guest_cannot_favorite_product()
{
    $product = Product::factory()->create();

    $response = $this->post("/products/{$product->id}/favorite");

    $response->assertRedirect('/login');
}
}
