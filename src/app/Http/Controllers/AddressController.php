<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function edit(Product $product)
    {
        $user = auth()->user();
        $addresses = $user->addresses;

        return view('purchase.address', compact('product', 'addresses'));
    }

    public function update(AddressRequest $request)
{
    $data = $request->validated();

    $user = auth()->user();

    DB::transaction(function () use ($user, $data) {

        $user->addresses()->update(['is_default' => false]);

        $user->addresses()->create([
            'postal_code' => $data['postal_code'],
            'prefecture'  => $data['prefecture'],
            'city'        => $data['city'],
            'street'      => $data['street'],
            'building'    => $data['building'] ?? null,
            'is_default'  => true,
        ]);
    });

    return redirect()->route('purchase.create', ['product' => $data['product_id']])
                     ->with('success', '住所が更新されました');
}

    public function destroy(Address $address)
{
    // 自分の住所かチェック（重要）
    if ($address->user_id !== auth()->id()) {
        abort(403);
    }

    $address->delete();

    return back()->with('success', '住所を削除しました');
}

    public function setDefault(Address $address)
    {
        $user = auth()->user();

        if ($address->user_id !== $user->id) {
            abort(403);
        }

        DB::transaction(function () use ($user, $address) {
            $user->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return back()->with('success', 'デフォルト住所を変更しました');
    }
}