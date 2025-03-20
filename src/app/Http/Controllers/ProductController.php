<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
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
