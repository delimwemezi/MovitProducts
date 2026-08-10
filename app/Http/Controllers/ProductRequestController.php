<?php

namespace App\Http\Controllers;

use App\Mail\ProductRequestSubmitted;
use App\Models\BusinessProfile;
use App\Models\Product;
use App\Models\ProductRequestItem;
use App\Models\ProductRequestList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProductRequestController extends Controller
{
    public function create()
    {
        $products = Product::all();
        $business = BusinessProfile::first();

        return view('product-lists.create', compact('products', 'business'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'whatsapp_number' => 'nullable|string|max:30',
            'location' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.cartons' => 'nullable|integer|min:0',
            'items.*.pieces' => 'nullable|integer|min:0',
        ]);

        $business = BusinessProfile::firstOrCreate([
            'email' => config('mail.from.address', 'admin@movitproducts.com'),
        ], [
            'location' => 'Not set yet',
            'phone' => 'Not set yet',
        ]);

        $totalAmount = 0;
        $items = [];

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $cartons = (int) ($item['cartons'] ?? 0);
            $pieces = (int) ($item['pieces'] ?? 0);

            $unitPrice = (float) $product->carton_price;
            $itemTotal = ($cartons * $unitPrice) + ($pieces * (float) $product->piece_price);
            $totalAmount += $itemTotal;

            $items[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'cartons' => $cartons,
                'pieces' => $pieces,
                'unit_price' => $unitPrice,
                'total_price' => $itemTotal,
            ];
        }

        $list = ProductRequestList::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->email,
            'phone' => $request->phone,
            'whatsapp_number' => $request->whatsapp_number ?: $request->phone,
            'location' => $request->location,
            'notes' => $request->notes,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        foreach ($items as $item) {
            $list->items()->create($item);
        }

        $payload = [
            'customer_name' => $list->customer_name,
            'phone' => $list->phone,
            'location' => $list->location,
            'notes' => $list->notes,
            'total_amount' => $list->total_amount,
            'items' => $items,
            'created_at' => $list->created_at->format('d M Y H:i'),
        ];

        $adminEmail = $business->email ?: config('mail.from.address');
        Mail::to($adminEmail)->send(new ProductRequestSubmitted($payload));

        return redirect()->route('product-lists.history')->with('success', 'Your product request list has been sent successfully.');
    }

    public function history()
    {
        $lists = ProductRequestList::with('items.product')
            ->when(Auth::check(), fn ($query) => $query->where('user_id', Auth::id()))
            ->latest()
            ->get();

        return view('product-lists.history', compact('lists'));
    }
}
