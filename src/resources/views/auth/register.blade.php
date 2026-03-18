@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="register-container">

<h1 class="register-title">会員登録</h1>

<form method="POST" action="{{ route('register') }}" class="register-form">
@csrf


<div class="form-group">
<label for="name" class="form-label">お名前</label>

<input
id="name"
type="text"
name="name"
value="{{ old('name') }}"
class="form-input">

@error('name')
<div class="error-message">{{ $message }}</div>
@enderror
</div>



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



<div class="form-group">
<label for="password_confirmation" class="form-label">
確認用パスワード
</label>

<input
id="password_confirmation"
type="password"
name="password_confirmation"
class="form-input">

@error('password_confirmation')
<div class="error-message">{{ $message }}</div>
@enderror
</div>


<button type="submit" class="btn btn-primary">
登録する
</button>

</form>


<div class="login-link">
<a href="{{ route('login') }}" class="btn btn-secondary">
ログインはこちら
</a>
</div>

</div>

@endsection