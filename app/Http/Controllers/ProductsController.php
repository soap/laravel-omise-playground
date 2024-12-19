<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        
        return view('products.show', compact('product'));
    }
}
