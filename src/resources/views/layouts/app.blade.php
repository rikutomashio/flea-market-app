<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'フリマアプリ') }}</title>

   <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    @yield('css')

</head>

<body>

<header class="header">
    <div class="container">

        <nav class="nav header-nav">

    <a href="{{ route('products.index') }}">ホーム</a>

    @auth
    <span class="user-name">
        {{ Auth::user()->name }}
    </span>
    @endauth

    @auth
        <a href="{{ route('mypage') }}">マイページ</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
    @else
        <a href="{{ route('login') }}">ログイン</a>
        <a href="{{ route('register') }}">会員登録</a>
    @endauth

    <a href="{{ route('products.create') }}">出品</a>

</nav>

    </div>
</header>

<main class="main">
    <div class="container">
        @yield('content')
    </div>
</main>

</body>
</html>