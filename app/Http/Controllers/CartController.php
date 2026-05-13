<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
  public function add($id)
{
    $product = Product::findOrFail($id);

    $cart = session()->get('cart', []);

    if(isset($cart[$id])){
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "price" => $product->price,
            "image" => $product->image,
            "quantity" => 1
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back();
}

public function removeFromCart($id)
{
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return response()->json([
        'success' => true,
        'cartCount' => count($cart)
    ]);
}
}

