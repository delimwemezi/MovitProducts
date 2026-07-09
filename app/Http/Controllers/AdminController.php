<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    private function checkAuth()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            Auth::logout();
            return redirect('/admin/login');
        }

        $timeout = 15 * 60;
        if (session('last_activity') && (time() - session('last_activity') > $timeout)) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect('/admin/login')->with('error', 'Session expired. Please login again.');
        }

        session(['last_activity' => time()]);
        return null;
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_admin) {
                session(['last_activity' => time()]);
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }
            Auth::logout();
            return back()->with('error', 'You are not an admin.');
        }
        return back()->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        return view('admin.dashboard');
    }

    public function products()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function create()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'name'        => 'required|string|max:255',
            'carton_price'=> 'required|numeric|min:0',
            'piece_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|url',
        ]);

        Product::create([
            'name'         => $request->name,
            'carton_price' => $request->carton_price,
            'piece_price'  => $request->piece_price,
            'description'  => $request->description,
            'category_id'  => $request->category_id,
            'image'        => $request->input('image'),
        ]);

        return redirect('/admin/products')->with('success', 'Product saved successfully!');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit', compact('product', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'name'         => 'required|string|max:255',
            'carton_price' => 'required|numeric|min:0',
            'piece_price'  => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'nullable|url',
        ]);

        $product = Product::findOrFail($id);
        $data = [
            'name'         => $request->name,
            'carton_price' => $request->carton_price,
            'piece_price'  => $request->piece_price,
            'description'  => $request->description,
            'category_id'  => $request->category_id,
        ];

        if ($request->input('image')) {
            $data['image'] = $request->input('image');
        }

        $product->update($data);
        return redirect('/admin/products')->with('success', 'Product Updated');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/admin/products')->with('success', 'Product Deleted');
    }

    public function orders()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return back()->with('success', 'Order status updated');
    }

    public function cancelOrder(int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();
        return back()->with('success', 'Order cancelled');
    }

    public function admins()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $admins = User::where('is_admin', true)->get();
        return view('admin.admins', compact('admins'));
    }

    public function createAdmin(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:12',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => true,
        ]);

        return redirect()->back()->with('success', 'Admin created!');
    }

    public function destroyAdmin(int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'You cannot delete your own admin account.');
        }

        User::where('id', $id)->where('is_admin', true)->delete();
        return redirect()->back()->with('success', 'Admin removed!');
    }
}

