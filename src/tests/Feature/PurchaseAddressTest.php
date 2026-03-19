<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use Tests\TestCase;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function updated_address_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $address = Address::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'prefecture' => '東京都',
            'city' => '新宿区',
            'street' => '西新宿1-1-1',
            'building' => 'テストビル',
            'is_default' => true
        ]);

        $response = $this->actingAs($user)
            ->get("/purchase/{$product->id}");

        $response->assertSee('123-4567');
        $response->assertSee('東京都');
    }

    /** @test */
    public function purchased_item_has_shipping_address()
    {
    $user = User::factory()->create();

    $product = Product::factory()->create();

    $address = Address::create([
        'user_id' => $user->id,
        'postal_code' => '987-6543',
        'prefecture' => '大阪府',
        'city' => '大阪市',
        'street' => '梅田1-1',
        'building' => 'サンプルビル',
        'is_default' => true
    ]);

    // success処理で使うセッションを作る
    session([
        'purchase_address_id' => $address->id,
        'purchase_method' => 'card',
    ]);

    // Stripe成功後の処理を直接呼ぶ
    $response = $this->actingAs($user)
        ->get("/purchase/success/{$product->id}");

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'is_sold' => 1
    ]);
    }
}
