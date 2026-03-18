<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $page = $request->query('page', 'profile'); // デフォルトはプロフィール

        $products = collect();

        if ($page === 'buy') {
            // 購入商品の product 情報だけ取り出して統一
            $products = $user->purchases()->with('product')->get()->map(function ($purchase) {
                $product = $purchase->product;
                // 作成日を持たせたい場合
                $product->purchase_date = $purchase->created_at;
                return $product;
            });
        } elseif ($page === 'sell') {
            $products = $user->products()->get();
        }

        return view('mypage', compact('user', 'products', 'page'));
    }
}