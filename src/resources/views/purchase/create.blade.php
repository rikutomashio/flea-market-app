@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<h1 class="page-title">購入確認</h1>

<div class="purchase-page">

    {{-- 左：商品情報 --}}
    <div class="purchase-item">

        @if($product->image_path)
            @if(Str::startsWith($product->image_path, 'http'))
                <img src="{{ $product->image_path }}" alt="{{ $product->name }}" class="purchase-image">
            @else
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="purchase-image">
            @endif
        @else
            <p>画像はありません。</p>
        @endif

        <h2 class="purchase-name">{{ $product->name }}</h2>

        <p class="purchase-price">
            ¥{{ number_format($product->price) }}
        </p>

    </div>


    {{-- 右：購入フォーム --}}
    <div class="purchase-form">

    @if($product->is_sold)

        <p class="sold-text">SOLD</p>

    @else

    <form method="POST" action="{{ route('purchase.store', $product) }}">
    @csrf

        {{-- =========================
            配送先
        ========================== --}}
        <h3>配送先</h3>

        @error('address_id')
            <div class="error-message">{{ $message }}</div>
        @enderror

        @foreach ($addresses as $address)

        <div class="address-box">

            <label>
                <input type="radio"
                       name="address_id"
                       value="{{ $address->id }}"
                       {{ old('address_id', optional($addresses->firstWhere('is_default', true))->id) == $address->id ? 'checked' : '' }}>

                〒{{ $address->postal_code }}
                {{ $address->prefecture }}
                {{ $address->city }}
                {{ $address->street }}
                {{ $address->building }}

            </label>

            @if($address->is_default)
                <a href="{{ route('purchase.address.edit', $product->id) }}"
                   class="btn btn-secondary address-link">
                   住所変更
                </a>
            @endif

        </div>

        @endforeach


        {{-- =========================
            支払い方法
        ========================== --}}
        <h3>支払い方法</h3>

        <select name="payment_method" class="payment-select">
            <option value="">選択してください</option>
            <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>
                コンビニ支払い
            </option>
            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>
                カード支払い
            </option>
        </select>

        @error('payment_method')
            <div class="error-message">{{ $message }}</div>
        @enderror


        {{-- =========================
            ボタン
        ========================== --}}
        @if($addresses->count() > 0)

        <button type="submit" class="btn btn-primary">
            Stripe Checkout に進む
        </button>

        @else

        <p class="error-message">
            住所が登録されていません
        </p>

        @endif

    </form>

    @endif

    </div>

</div>


{{-- 戻る --}}
<div class="back-link">
<a href="{{ route('products.show', $product) }}"
   class="btn btn-secondary">
← 商品詳細に戻る
</a>
</div>

@endsection