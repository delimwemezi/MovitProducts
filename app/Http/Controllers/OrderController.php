<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{

public function checkout()
{
    return view('checkout');
}

public function placeOrder(Request $request)
{
    $total = 0;
    foreach(session('cart') as $item){
        $total += $item['price'] * $item['quantity'];
    }

    Order::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'address' => $request->address,
        'total' => $total
    ]);

    session()->forget('cart');

    return redirect('/')->with('success','Order placed!');

    
}


public function orders()
{
    $orders = Order::all();
    return view('admin.orders', compact('orders'));
}


    public function store(Request $request)
    {
        // Validate form
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        // Calculate total from cart
        $total = 0;
        foreach (session('cart', []) as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Save order
        Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $total,
        ]);

        Order::create([
    'name' => $request->name,
    'phone' => $request->phone,
    'address' => $request->address,
    'total' => $total,
    'status' => 'pending', // default
]);

        // Clear cart
        session()->forget('cart');

        return redirect()->back()->with('success', 'Order placed successfully!');
    }
}






