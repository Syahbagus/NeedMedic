<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        $categories = Category::all();
        return view('welcome', compact('products', 'categories'));
    }
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
