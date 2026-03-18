@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection

@section('content')

{{-- 🔎 検索フォーム --}}
<form method="GET" action="{{ route('products.index') }}" class="search-form">
    <input type="text" name="keyword"
           value="{{ request('keyword') }}"
           placeholder="商品名で検索">

    {{-- tabを保持 --}}
    @if(request('tab'))
        <input type="hidden" name="tab" value="{{ request('tab') }}">
    @endif

    <button type="submit" class="btn btn-primary">検索</button>
</form>

<h1>商品一覧</h1>

<div class="tab-menu">
    <a href="{{ route('products.index') }}"
       class="tab {{ request('tab') !== 'mylist' ? 'active' : '' }}">
        全商品
    </a>

    <a href="{{ route('products.index', ['tab' => 'mylist']) }}"
       class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}">
        マイリスト
    </a>
</div>

{{-- メッセージ --}}
@if(session('error'))
<div class="error-message">
    {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="success-message">
    {{ session('success') }}
</div>
@endif

{{-- 商品一覧 --}}
@if(request('tab') === 'mylist' && $products->isEmpty())
    <p>いいねした商品はありません</p>
@endif
<div class="product-grid">

@foreach ($products as $product)

<div class="product-card">

    <a href="{{ route('products.show', $product->id) }}">

        <div class="product-image">
            @php
            $image = $product->image_path;
            @endphp

            @if($image)
            @if(Str::startsWith($image, 'http'))
            <img src="{{ $image }}" alt="{{ $product->name }}">
            @else
            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}">
            @endif
            @else
            <p>画像なし</p>
            @endif
        </div>

        <div class="product-name">
            {{ $product->name }}
        </div>

        <div class="product-price">
            ¥{{ number_format($product->price) }}
        </div>

    </a>

@if($product->is_sold)
<span class="sold">SOLD</span>
@endif

</div>

@endforeach

</div>

@endsection