<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function store(Product $product)
    {
        $product->favorites()->create([
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function destroy(Product $product)
    {
        $product->favorites()->where('user_id', auth()->id())->delete();

        return back();
    }
}
