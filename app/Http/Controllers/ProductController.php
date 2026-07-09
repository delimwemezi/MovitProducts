<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // SHOW PRODUCTS (FILTER BY CATEGORY)
    public function index(Request $request)
    {
        $search     = $request->get('search');
        $categoryId = $request->get('category');

        $products = Product::query()
            ->with('primaryImage')  // ✅ Eager-load primary image
            ->when($categoryId, function($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when($search, function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->get();

        $categories = \App\Models\Category::all();

        return view('products.product', compact('products', 'categories'));
    }
}

