@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="mypage-container">

    {{-- プロフィール --}}
    <div class="profile-area">

        <img
        class="profile-image"
        src="{{ $user->profile_image 
            ? asset('storage/' . $user->profile_image) 
            : asset('images/default.png') }}"
        alt="プロフィール画像">

        <div class="profile-info">
            <h2 class="profile-name">{{ $user->name }}</h2>

            <a href="{{ route('profile.edit') }}" class="profile-edit-btn">
                プロフィール編集
            </a>
        </div>

    </div>


    {{-- タブ --}}
    <div class="mypage-tabs">

        <a href="{{ route('mypage', ['page' => 'sell']) }}"
        class="mypage-tab {{ $page === 'sell' ? 'active' : '' }}">
            出品商品
        </a>

        <a href="{{ route('mypage', ['page' => 'buy']) }}"
        class="mypage-tab {{ $page === 'buy' ? 'active' : '' }}">
            購入商品
        </a>

    </div>


    {{-- 商品一覧 --}}
    <div class="mypage-products">

        <h3 class="mypage-title">
        @if($page === 'buy')
            購入商品一覧
        @else
            出品商品一覧
        @endif
        </h3>


        @forelse($products as $item)

        <div class="mypage-product">

            <a href="{{ route('products.show', $item->id) }}">
                {{ $item->name }}
            </a>

            <div class="product-meta">
                <span>¥{{ number_format($item->price) }}</span>

                @if($page === 'buy')
                    <span>{{ $item->purchase_date->format('Y/m/d') }}</span>
                @endif

                @if($page === 'sell' && $item->is_sold)
                    <span class="mypage-sold">SOLD</span>
                @endif
            </div>

        </div>

        @empty

        <p class="empty-message">商品がありません</p>

        @endforelse


        @if(method_exists($products, 'links'))
        <div class="pagination-area">
            {{ $products->links() }}
        </div>
        @endif

    </div>

</div>

@endsection