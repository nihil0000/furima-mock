<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Display product list
    public function index(Request $request)
    {
        $tab = $request->query('page', 'recommend');
        $query = $request->query('query');

        if ($tab === 'mylist') {
            if (!auth()->check()) {
                return redirect()->guest(route('login.create'));
            }

            /** @var \App\Models\User $user */
            $user = auth()->user();

            // Apply search scope to product
            $favorites = $user->favorites()
                ->whereHas('product', function ($q) use ($query) {
                    if (!empty($query)) {
                        $q->search($query);
                    }

                    if (auth()->check()) {
                        $q->excludeOwn(auth()->id());
                    }
                })
                ->with('product')
                ->get();

            return view('product.index', compact('favorites', 'query'));
        }

        $products = Product::query();

        if (auth()->check()) {
            $products->excludeOwn(auth()->id());
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

        $isFavorited = $product->favorites->contains('user_id', auth()->id());

        $latestComments = $product->comments()
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        return view('product.show', compact('product', 'isFavorited', 'latestComments'));
    }


    // Display to exhibit product page
    public function create()
    {
        $categories = Category::all();

        return view('product.register', compact('categories'));
    }


    // Register the product
    public function store(ExhibitionRequest $request)
    {
        $user = auth()->user();

        $file = $request->image;
        $filename = $file->getClientOriginalName(); // Get the original filename of the uploaded file
        $file->storeAs('public/images', $filename); // Store the uploaded file

        $product = Product::create([
            'user_id' => $user->id,
            'product_name' => $request->product_name,
            'brand_name' => $request->brand_name,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
            'image' => 'images/' . $filename,
        ]);

        $product->categories()->attach($request->category);

        return redirect()->route('product.index');
    }
}
