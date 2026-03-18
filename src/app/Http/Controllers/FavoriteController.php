<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
   public function toggle(Product $product)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    if ($product->favoredUsers()->where('user_id', $user->id)->exists()) {
        $product->favoredUsers()->detach($user->id);
    } else {
        $product->favoredUsers()->attach($user->id);
    }

    return back();
}
}