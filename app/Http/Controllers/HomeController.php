<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // home page - just shows categories
    public function index()
    {
        $categories = Category::all();
        return view('home', compact('categories'));
    }

    // products page - handles filtering and search
    public function products(Request $request)
    {
        $search     = $request->get('search');
        $categoryId = $request->get('category');

        $products = Product::with('category')
            ->when($categoryId, function($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when($search, function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->get();

        $categories = Category::all();

        return view('products.product', compact('products', 'categories'));
    }
}