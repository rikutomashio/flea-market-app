@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')

<div class="sell-container">

    <div class="sell-card">

        <h2 class="sell-title">商品出品</h2>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="sell-form">
        @csrf

        {{-- 商品画像（上に持ってくると良い） --}}
        <div class="form-group">
            <label class="form-label">商品画像</label>
            <input type="file" name="image" class="form-input file-input">
        </div>

        {{-- 商品名 --}}
        <div class="form-group">
            <label class="form-label">商品名</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-input">
        </div>

        {{-- ブランド名 --}}
        <div class="form-group">
            <label class="form-label">ブランド名</label>
            <input type="text" name="brand" value="{{ old('brand') }}" class="form-input">
        </div>

        {{-- 価格 --}}
        <div class="form-group">
            <label class="form-label">価格</label>
            <input type="number" name="price" value="{{ old('price') }}" class="form-input">
        </div>

        {{-- 説明 --}}
        <div class="form-group">
            <label class="form-label">説明</label>
            <textarea name="description" class="form-textarea">{{ old('description') }}</textarea>
        </div>

        {{-- 商品状態 --}}
        <div class="form-group">
            <label class="form-label">商品の状態</label>

            <select name="condition" class="form-select">
                <option value="">選択してください</option>
                <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>良好</option>
                <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="3" {{ old('condition') == 3 ? 'selected' : '' }}>状態が悪い</option>
            </select>
        </div>

        {{-- カテゴリ --}}
        <div class="form-group">
            <label class="form-label">カテゴリ</label>

            <div class="category-grid">
                @foreach($categories as $category)
                <label class="category-checkbox">
                    <input type="checkbox"
                    name="category_ids[]"
                    value="{{ $category->id }}"
                    {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}>
                    {{ $category->name }}
                </label>
                @endforeach
            </div>
        </div>

        {{-- ボタン --}}
        <button type="submit" class="sell-button">
            出品する
        </button>

        </form>

    </div>

</div>

@endsection