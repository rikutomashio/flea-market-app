<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class PurchaseController extends Controller
{
    // 購入確認画面
    public function create(Product $product)
    {
        $addresses = Auth::user()->addresses;
        $defaultAddress = $addresses->where('is_default', true)->first();

        return view('purchase.create', compact('product', 'defaultAddress', 'addresses'));
    }

    // 購入確定処理（カード・コンビニ共通フロー）
    public function store(PurchaseRequest $request, Product $product)
{
    if ($product->is_sold) {
        return redirect()->route('products.index')
            ->with('error', 'この商品はすでに売り切れです');
    }

    $data = $request->validated();

    $address = Auth::user()
        ->addresses()
        ->findOrFail($data['address_id']);

    session([
        'purchase_product_id' => $product->id,
        'purchase_address_id' => $address->id,
        'purchase_method' => $data['payment_method'],
    ]);

    Stripe::setApiKey(config('services.stripe.secret')); // ←これも改善

    $checkoutSession = CheckoutSession::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => $product->price * 100,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('purchase.success', ['product' => $product->id]),
        'cancel_url' => route('purchase.create', ['product' => $product->id]),
    ]);

    return redirect($checkoutSession->url);
}

    // Stripe決済成功後の処理
    public function success(Product $product)
{
    $product->refresh();

    if ($product->is_sold) {
        return redirect()->route('products.index')
            ->with('error', 'すでに購入済みの商品です');
    }

    $addressId = session('purchase_address_id');
    $paymentMethod = session('purchase_method');

    if (!$addressId || !$paymentMethod) {
        return redirect()->route('products.index')
            ->with('error', '購入情報が取得できませんでした');
    }

    Purchase::create([
        'user_id' => Auth::id(),
        'product_id' => $product->id,
        'address_id' => $addressId,
        'payment_method' => $paymentMethod,
    ]);

    $product->update(['is_sold' => 1]);

    session()->forget(['purchase_product_id', 'purchase_address_id', 'purchase_method']);

    return redirect()->route('products.index')
        ->with('success', '購入が完了しました（' . $paymentMethod . '）');
}
}