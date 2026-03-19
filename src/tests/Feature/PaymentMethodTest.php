<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Stripe\Checkout\Session as StripeSession;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function session_is_stored_and_redirects_to_stripe_checkout_for_card_and_convenience_payment()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // デフォルト住所作成
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'is_default' => true,
        ]);

        // 商品作成
        $product = Product::factory()->create();

        // ------------------------
        // Stripe Checkout Session をモック
        // ------------------------
        $mockSession = Mockery::mock('overload:' . StripeSession::class);
        $mockSession->shouldReceive('create')
            ->andReturn((object)['url' => 'https://checkout.stripe.com/mock-session']);

        // --- コンビニ支払い ---
        $responseConvenience = $this->actingAs($user)->post(route('purchase.store', $product), [
            'payment_method' => 'convenience',
            'address_id' => $address->id,
        ]);

        $responseConvenience->assertRedirect('https://checkout.stripe.com/mock-session');
        $this->assertEquals(session('purchase_product_id'), $product->id);
        $this->assertEquals(session('purchase_address_id'), $address->id);
        $this->assertEquals(session('purchase_method'), 'convenience');

        // --- カード支払い ---
        $product2 = Product::factory()->create();

        $responseCard = $this->actingAs($user)->post(route('purchase.store', $product2), [
            'payment_method' => 'card',
            'address_id' => $address->id,
        ]);

        $responseCard->assertRedirect('https://checkout.stripe.com/mock-session');
        $this->assertEquals(session('purchase_product_id'), $product2->id);
        $this->assertEquals(session('purchase_address_id'), $address->id);
        $this->assertEquals(session('purchase_method'), 'card');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}