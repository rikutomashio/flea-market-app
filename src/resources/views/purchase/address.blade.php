@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

<div class="address-container">

    {{-- タイトル --}}
    <h2 class="address-title">送付先住所の管理</h2>

    {{-- 成功メッセージ --}}
    @if(session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
    @endif

    {{-- エラーメッセージ（セッション） --}}
    @if(session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
    @endif


    {{-- =========================
        ① 登録済み住所
    ========================== --}}
    <div class="address-card">

        <h3 class="address-subtitle">登録済み住所</h3>

        @if($addresses->count() > 0)

        <table class="address-table">
            <thead>
                <tr>
                    <th>住所</th>
                    <th>状態</th>
                    <th>操作</th>
                </tr>
            </thead>

            <tbody>
                @foreach($addresses as $address)
                <tr>
                    <td>
                        〒{{ $address->postal_code }}<br>
                        {{ $address->prefecture }} {{ $address->city }} {{ $address->street }}<br>
                        {{ $address->building }}
                    </td>

                    <td>
                        @if($address->is_default)
                        <span class="default-label">デフォルト</span>
                        @endif
                    </td>

                    <td>
                        @if(!$address->is_default)
                        <form
                            action="{{ route('addresses.setDefault', $address) }}"
                            method="POST"
                            class="inline-form">

                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn-secondary small">
                                デフォルトにする
                            </button>

                        </form>
                        @endif

                        {{-- ★ 削除ボタン（ここに追加） --}}
                        <form action="{{ route('addresses.destroy', $address) }}"
                            method="POST"
                            class="inline-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-danger small">
                                削除
                            </button>

    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <p>住所が登録されていません。</p>
        @endif

    </div>


    {{-- =========================
        ② 新規住所追加
    ========================== --}}
    <div class="address-card">

        <h3 class="address-subtitle">新しい住所を追加</h3>

        {{-- ★ novalidate追加 --}}
        <form method="POST"
            action="{{ route('address.update') }}"
            class="address-form"
            novalidate>

            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            {{-- 郵便番号 --}}
            <div class="form-group">
                <label>郵便番号</label>
                <input type="text"
                    name="postal_code"
                    value="{{ old('postal_code') }}"
                    class="form-input">

                @error('postal_code')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- 都道府県 --}}
            <div class="form-group">
                <label>都道府県</label>
                <input type="text"
                    name="prefecture"
                    value="{{ old('prefecture') }}"
                    class="form-input">

                @error('prefecture')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- 市区町村 --}}
            <div class="form-group">
                <label>市区町村</label>
                <input type="text"
                    name="city"
                    value="{{ old('city') }}"
                    class="form-input">

                @error('city')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- 番地 --}}
            <div class="form-group">
                <label>番地</label>
                <input type="text"
                    name="street"
                    value="{{ old('street') }}"
                    class="form-input">

                @error('street')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- 建物名 --}}
            <div class="form-group">
                <label>建物名</label>
                <input type="text"
                    name="building"
                    value="{{ old('building') }}"
                    class="form-input">

                @error('building')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- ボタン --}}
            <button type="submit" class="btn-primary">
                登録する
            </button>

        </form>

    </div>


    {{-- 戻る --}}
    <a href="{{ route('purchase.create', $product) }}" class="btn-secondary back-button">
        ← 購入確認画面へ戻る
    </a>

</div>

@endsection