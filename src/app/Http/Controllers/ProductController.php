<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ProductController extends Controller
{
    public function index(Request $request)
{   
    $keyword = $request->keyword;
    $tab = $request->tab;

    $query = Product::query();

    // 🔹 自分の商品は除外（ログイン時）
    if (Auth::check()) {
        $query->where('user_id', '!=', Auth::id());
    }

    // 🔎 商品名部分一致検索
    if ($request->filled('keyword')) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
    }

    // 🩷 マイリストタブ
    if ($request->tab === 'mylist' && Auth::check()) {
        $query->whereHas('favoredUsers', function ($q) {
            $q->where('user_id', Auth::id());
        });
    }

    $products = $query->get();

   return view('products.index', compact('products', 'keyword', 'tab'));
}




    public function show($id)
{
    $product = Product::with([
    'user',
    'categories',
    'comments.user'
])->findOrFail($id);

    return view('products.show', compact('product'));
}

    public function create()
{
    $categories = Category::all();

    return view('products.create', compact('categories'));
}

public function store(ExhibitionRequest $request)
{
    $data = $request->validated();

    $imagePath = $request->file('image')->store('products', 'public');

    $product = Product::create([
        'user_id' => auth()->id(),
        'name' => $data['name'],
        'price' => $data['price'],
        'description' => $data['description'],
        'image_path' => $imagePath,
        'brand' => $data['brand'] ?? null,
        'condition' => $data['condition'],
        'is_sold' => 0,
    ]);

    $product->categories()->attach($data['category_ids']);

    return redirect()->route('mypage', ['page' => 'sell'])
                     ->with('success', '商品を出品しました');
}

}
