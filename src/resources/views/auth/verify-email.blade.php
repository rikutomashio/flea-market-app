<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メール認証</title>
</head>
<body>
    <h2>メール認証が必要です</h2>

    <p>
        登録したメールアドレスに認証リンクを送信しました。<br>
        メールを確認してください。
    </p>

    {{-- 認証メール再送 --}}
    @if (session('status') == 'verification-link-sent')
        <p style="color: green;">認証メールを再送しました。メールを確認してください。</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証メールを再送信</button>
    </form>

    {{-- 認証はこちらからボタン --}}
    <p>
        認証リンクが届いていない場合は、下のボタンをクリックして認証メールを確認してください。
    </p>

    {{-- 修正: verification.notice ではなく verification.send に POST --}}
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証はこちらから</button>
    </form>
</body>
</html>