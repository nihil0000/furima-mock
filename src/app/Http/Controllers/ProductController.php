<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Display product list
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $query = $request->query('query');

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                return redirect()->guest(route('login.create'));
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Apply search scope to product
            $favorites = $user->favorites()
                ->whereHas('product', function ($q) use ($query) {
                    if (!empty($query)) {
                        $q->search($query);
                    }

                    if (Auth::check()) {
                        $q->excludeOwn(Auth::id());
                    }
                })
                ->with('product')
                ->get();

            return view('product.index', compact('favorites', 'query'));
        }

        $products =Product::query();

        if (Auth::check()) {
            $products->excludeOwn(Auth::id());
        }

        if (!empty($query)) {
            $products->search($query);
        }

        $products = $products->get();

        return view('product.index', compact('products', 'query'));
    }

    // Show product details
    public function show(Product $product)
    {
        $product->loadCount(['favorites', 'comments']);
        $product->load(['categories', 'comments.user']);

        $randomComments = $product->comments->shuffle()->take(3);

        return view('product.show', compact('product', 'randomComments'));
    }

    public function create()
    {
        return view('product.register');
    }

    public function store()
    {
        return redirect()->route('product.index');
    }
}
