@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')

<div class="product-detail">

    {{-- 商品画像 --}}
    <div class="product-detail-image">

        @if($product->image_path)
            @if(Str::startsWith($product->image_path, 'http'))
                <img src="{{ $product->image_path }}" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
            @endif
        @else
            <p>画像はありません</p>
        @endif

    </div>


    {{-- 商品情報 --}}
    <div class="product-detail-info">

        <h2 class="detail-product-name">{{ $product->name }}</h2>

        <p class="detail-product-price">¥{{ number_format($product->price) }}</p>

        <p>ブランド：{{ $product->brand ?? 'なし' }}</p>
        <p>出品者：{{ $product->user->name }}</p>
        <p>カテゴリ：{{ $product->categories->pluck('name')->implode(', ') }}</p>

        <p>
        状態：
        @switch($product->condition)
            @case(1) 良好 @break
            @case(2) やや傷や汚れあり @break
            @case(3) 状態が悪い @break
            @default 不明
        @endswitch
        </p>

        {{-- いいね --}}
        <div class="favorite-area">

        @auth
            <form method="POST" action="{{ route('products.favorite', $product) }}">
                @csrf

                @if(auth()->user()->favorites->contains($product->id))
                    <button class="favorite-button">🤍 お気に入り解除</button>
                @else
                    <button class="favorite-button">❤️ お気に入りに追加</button>
                @endif

                <span>❤️ {{ $product->favoredUsers->count() }}</span>

            </form>
        @else
            <p>❤️ {{ $product->favoredUsers->count() }}</p>
        @endauth

        </div>


        {{-- 購入 --}}
        <div class="purchase-area">

        @if($product->is_sold)
            <p class="sold-text">SOLD</p>
        @else
            <a href="{{ route('purchase.create', $product) }}" class="btn btn-success">
                購入する
            </a>
        @endif

        </div>

    </div>

</div>


<h3>商品説明</h3>
<p class="product-description">{{ $product->description }}</p>


<hr>

<h3>コメント一覧</h3>

@forelse($product->comments as $comment)

<div class="comment-box">

<strong>{{ $comment->user->name }}</strong>

<p>{{ $comment->content }}</p>

</div>

@empty

<p>まだコメントはありません</p>

@endforelse


<hr>


{{-- コメント投稿 --}}
@auth

<h3>コメントを投稿する</h3>

<form method="POST"
      action="{{ route('comment.store', $product) }}"
      class="comment-form">

@csrf

<textarea name="content"
          class="comment-textarea"
          rows="4"
          placeholder="コメントを書く...">{{ old('content') }}</textarea>

@error('content')
    <div class="error-message">{{ $message }}</div>
@enderror

<button type="submit"
        class="btn btn-primary comment-submit">
    コメントする
</button>

</form>

@endauth

@endsection