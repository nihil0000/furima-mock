<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Product $product)
    {
        $product->favorites()->create([
            'user_id' => Auth::id(),
        ]);

        return back();
    }

    public function destroy(Product $product)
    {
        $product->favorites()->where('user_id', Auth::id())->delete();

        return back();
    }
}
