<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $product)
    {
        $product->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back();
    }
}
