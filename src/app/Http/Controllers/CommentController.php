<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Product;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $product)
{
    $data = $request->validated();

    Comment::create([
        'product_id' => $product->id,
        'user_id' => auth()->id(),
        'content' => $data['content'],
    ]);

    return redirect()->route('products.show', $product)
                     ->with('success', 'コメントを投稿しました');
}
}