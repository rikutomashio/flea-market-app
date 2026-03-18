@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection

@section('content')

<h1 class="page-title">マイリスト</h1>

<div class="page-actions">
    <a href="{{ route('home') }}" class="btn btn-primary">
        商品一覧に戻る
    </a>
</div>


@if($favorites->isEmpty())

<p class="empty-message">まだお気に入りはありません。</p>

@else

<div class="product-list">

@foreach($favorites as $product)

<div class="product-card">

<a href="{{ route('products.show', $product->id) }}" class="product-link">

@if($product->image_path)
<img
src="{{ asset('storage/' . $product->image_path) }}"
class="product-image">
@endif

<div class="product-info">

<span class="product-name">
{{ $product->name }}
</span>

<span class="product-price">
¥{{ number_format($product->price) }}
</span>

@if($product->is_sold)
<span class="sold-label">SOLD</span>
@endif

</div>

</a>

</div>

@endforeach

</div>

@endif

@endsection