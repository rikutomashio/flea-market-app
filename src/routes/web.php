<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;



/*
|--------------------------------------------------------------------------
| 商品関連（ログイン不要）
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/item/{product}', [ProductController::class, 'show'])
    ->name('products.show');


/*
|--------------------------------------------------------------------------
| ログイン必要
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');

    // マイリスト
    Route::get('/mylist', [FavoriteController::class, 'index'])->name('mylist');

    // いいね
    Route::post('/products/{product}/favorite', [FavoriteController::class, 'toggle'])
    ->name('products.favorite');

    // 出品
    Route::get('/sell', [ProductController::class, 'create'])->name('products.create');
    Route::post('/sell', [ProductController::class, 'store'])->name('products.store');

    // 購入
    Route::get('/purchase/{product}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{product}', [PurchaseController::class, 'store'])->name('purchase.store');

    // 住所変更
    Route::get('/purchase/address/{product}', [AddressController::class, 'edit'])->name('purchase.address.edit');
    Route::post('/address', [AddressController::class, 'update'])->name('address.update');
    Route::patch('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
    // Stripeチェックアウト（カード決済用）
    Route::get('/stripe/checkout', function() {
        return "ここにStripe Checkout画面を実装";
    })->name('stripe.checkout');
    // Stripe決済成功後のリダイレクト
    Route::get('/purchase/success/{product}', [PurchaseController::class, 'success'])
    ->name('purchase.success');

    Route::post('/comment/{product}', [App\Http\Controllers\CommentController::class, 'store'])
        ->name('comment.store');



});

/*
|--------------------------------------------------------------------------
| メール認証必須エリア
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // プロフィール編集画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/mypage/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

});
/*
|--------------------------------------------------------------------------
| その他
|--------------------------------------------------------------------------
*/


require __DIR__.'/auth.php';
