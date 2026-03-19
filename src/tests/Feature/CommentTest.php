<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_comment()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
            ->post("/comment/{$product->id}", [
                'content' => 'テストコメント'
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_guest_cannot_comment()
    {
        $product = Product::factory()->create();

        $response = $this->post("/comment/{$product->id}", [
            'content' => 'テストコメント'
        ]);

        $response->assertRedirect('/login');
    }

    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
            ->post("/comment/{$product->id}", [
                'content' => ''
            ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_comment_must_be_less_than_255_characters()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $longComment = str_repeat('a', 256);

        $response = $this->actingAs($user)
            ->post("/comment/{$product->id}", [
                'content' => $longComment
            ]);

        $response->assertSessionHasErrors('content');
    }
}