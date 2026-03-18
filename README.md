#フリマアプリ

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/


## 概要

本アプリはLaravelを用いて開発したフリマアプリです。
ユーザーは商品を出品・購入でき、いいねやコメント機能を通じて他ユーザーと交流できます。

## 主な機能
# 商品関連

商品一覧表示

商品詳細表示

商品検索

商品出品

売り切れ表示

# ユーザーアクション

いいね機能

コメント機能

# 購入機能

商品購入

支払い方法選択（Stripe）

# ユーザー管理

会員登録 / ログイン（Laravel Fortify）

マイページ表示

プロフィール編集

## ER図

※ER図画像をここに貼る

## 使用技術

PHP 8.x

Laravel 10.x

MySQL

Laravel Fortify（認証）

Stripe（決済）

## 環境構築
① リポジトリをクローン
git clone https://github.com/<ユーザー名>/<リポジトリ名>.git
cd <プロジェクト名>
② 依存関係インストール
composer install
npm install
npm run dev
③ 環境変数設定
cp .env.example .env
php artisan key:generate
④ DB設定

.env に以下を設定

DB_DATABASE=xxxx
DB_USERNAME=xxxx
DB_PASSWORD=xxxx
⑤ マイグレーション
php artisan migrate
⑥ 起動
php artisan serve
# テスト
php artisan test

## テーブル構成

users

products

purchases

addresses

favorites

comments

categories

category_product（中間テーブル）

## 画面一覧
画面	URL
商品一覧	/
商品詳細	/item/{id}
ログイン	/login
会員登録	/register
マイページ	/mypage
出品	/sell
プロフィール編集	/mypage/profile

## 工夫した点

売り切れ商品の表示制御

いいね・コメントの非同期的なユーザー体験

マイページで出品商品・購入商品を分離表示

中間テーブルを用いたカテゴリ管理

## 注意事項

Stripeはテストモードで動作します

画像アップロードはstorage配下に保存されます

## 作成者

名前 真尾陸人
