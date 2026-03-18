@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="login-container">

<h1 class="login-title">ログイン</h1>

<form method="POST" action="{{ route('login') }}" class="login-form">
@csrf

<div class="form-group">
<label for="email" class="form-label">メールアドレス</label>

<input
id="email"
type="email"
name="email"
value="{{ old('email') }}"
class="form-input">

@error('email')
<div class="error-message">{{ $message }}</div>
@enderror
</div>


<div class="form-group">
<label for="password" class="form-label">パスワード</label>

<input
id="password"
type="password"
name="password"
class="form-input">

@error('password')
<div class="error-message">{{ $message }}</div>
@enderror
</div>


<button type="submit" class="btn btn-primary">
ログイン
</button>

</form>


<div class="register-link">
<a href="{{ route('register') }}" class="btn btn-secondary">
会員登録はこちら
</a>
</div>

</div>

@endsection