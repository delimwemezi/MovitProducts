<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        Category::create([
            'name' => $request->name
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back();
    }
}

