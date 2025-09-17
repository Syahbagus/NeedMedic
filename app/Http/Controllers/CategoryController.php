<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $products = $category->products()->latest()->get();
        $categories = Category::all();

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
