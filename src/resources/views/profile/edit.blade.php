@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

<div class="profile-container">

    <div class="profile-card">

        <h2 class="profile-title">プロフィール編集</h2>

        @if(session('status') === 'profile-updated')
        <div class="success-message">
            プロフィールを更新しました
        </div>
        @endif

        <form method="POST"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
        class="profile-form">

        @csrf
        @method('PATCH')

        {{-- 画像 --}}
        <div class="profile-image-area">

            <img
            src="{{ $user->profile_image 
                ? asset('storage/' . $user->profile_image) 
                : asset('images/default.png') }}"
            class="profile-image">

            <input type="file"
            name="profile_image"
            class="form-input file-input">

        </div>


        {{-- ユーザー名 --}}
        <div class="form-group">
            <label>ユーザー名</label>
            <input
            type="text"
            name="name"
            value="{{ old('name', $user->name) }}"
            class="form-input">

            @error('name')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>


        {{-- メール --}}
        <div class="form-group">
            <label>メールアドレス</label>
            <input
            type="email"
            name="email"
            value="{{ old('email', $user->email) }}"
            class="form-input">

            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>


        {{-- 住所 --}}
        <div class="form-group">
            <label>郵便番号</label>
            <input
            type="text"
            name="postal_code"
            value="{{ old('postal_code', $defaultAddress->postal_code ?? '') }}"
            class="form-input">
        </div>

        <div class="form-group">
            <label>都道府県</label>
            <input
            type="text"
            name="prefecture"
            value="{{ old('prefecture', $defaultAddress->prefecture ?? '') }}"
            class="form-input">
        </div>

        <div class="form-group">
            <label>市区町村</label>
            <input
            type="text"
            name="city"
            value="{{ old('city', $defaultAddress->city ?? '') }}"
            class="form-input">
        </div>

        <div class="form-group">
            <label>番地</label>
            <input
            type="text"
            name="street"
            value="{{ old('street', $defaultAddress->street ?? '') }}"
            class="form-input">
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input
            type="text"
            name="building"
            value="{{ old('building', $defaultAddress->building ?? '') }}"
            class="form-input">
        </div>


        {{-- ボタン --}}
        <div class="profile-buttons">
            <button type="submit" class="btn-primary">
                更新する
            </button>

            <a href="{{ route('mypage') }}" class="btn-secondary">
                戻る
            </a>
        </div>

        </form>

    </div>

</div>

@endsection