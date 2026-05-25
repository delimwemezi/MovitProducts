<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    // =========================
    // 🔐 AUTH CHECK
    // =========================

    private function checkAuth()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            Auth::logout();
            return redirect('/admin/login');
        }

        $timeout = 5 * 60;

        if (session('last_activity') && (time() - session('last_activity') > $timeout)) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect('/admin/login')->with('error', 'Session expired. Please login again.');
        }

        session(['last_activity' => time()]);
        return null;
    }

    // =========================
    // 🔐 LOGIN SECTION
    // =========================

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

    // =========================
    // 📊 DASHBOARD
    // =========================

    public function dashboard()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        return view('admin.dashboard');
    }

    // =========================
    // 📦 PRODUCTS SECTION
    // =========================

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
            'image_file'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'image_url'   => 'nullable|url',
        ]);

        $imagePath = null;

        if ($request->hasFile('image_file')) {
            $uploaded  = cloudinary()->uploadApi()->upload(
                $request->file('image_file')->getRealPath(),
                ['folder' => 'products']
            );
            $imagePath = $uploaded['secure_url'];

        } elseif ($request->filled('image_url')) {
            $url    = $request->input('image_url');
            $parsed = parse_url($url);

            if (!isset($parsed['scheme']) || !in_array(strtolower($parsed['scheme']), ['http', 'https'])) {
                return back()->withInput()->withErrors(['image_url' => 'Only http and https URLs are allowed.']);
            }

            $host = strtolower($parsed['host'] ?? '');

            if (in_array($host, ['localhost', '127.0.0.1', '::1'])) {
                return back()->withInput()->withErrors(['image_url' => 'This URL is not allowed.']);
            }

            if (filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                if (!filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return back()->withInput()->withErrors(['image_url' => 'Private or reserved IP addresses are not allowed.']);
                }
            }

            if (strpos($host, '.') === false) {
                return back()->withInput()->withErrors(['image_url' => 'This URL is not allowed.']);
            }

            $response = Http::timeout(15)->get($url);

            if ($response->successful()) {
                $contentType  = $response->header('Content-Type');
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $isValidImage = false;

                foreach ($allowedTypes as $type) {
                    if (str_contains(strtolower($contentType), $type)) {
                        $isValidImage = true;
                        break;
                    }
                }

                if (!$isValidImage) {
                    return back()->withInput()->withErrors(['image_url' => 'URL did not return a valid image.']);
                }

                // ✅ Upload the URL directly to Cloudinary instead of saving locally
                $uploaded  = cloudinary()->uploadApi()->upload($url, ['folder' => 'products']);
                $imagePath = $uploaded['secure_url'];

            } else {
                return back()->withInput()->withErrors(['image_url' => 'Failed to download image. Check the URL and try again.']);
            }
        }

        Product::create([
            'name'         => $request->name,
            'carton_price' => $request->carton_price,
            'piece_price'  => $request->piece_price,
            'description'  => $request->description,
            'category_id'  => $request->category_id,
            'image'        => $imagePath,
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
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $data = [
            'name'         => $request->name,
            'carton_price' => $request->carton_price,
            'piece_price'  => $request->piece_price,
            'description'  => $request->description,
            'category_id'  => $request->category_id,
        ];

        // ✅ Upload new image and include in update data
        if ($request->hasFile('image')) {
            $uploaded      = cloudinary()->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'products']
            );
            $data['image'] = $uploaded['secure_url'];
        }

        $product->update($data);

        return redirect('/admin/products')->with('success', 'Product Updated');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $product = Product::findOrFail($id);

        // ✅ Delete image from Cloudinary (not local disk)
        if ($product->image) {
            try {
                $path        = parse_url($product->image, PHP_URL_PATH);
                $path        = preg_replace('/\/v\d+\//', '/', $path);
                $parts       = explode('/upload/', $path);
                $publicId    = pathinfo($parts[1] ?? '', PATHINFO_FILENAME);
                $folder      = dirname($parts[1] ?? '');
                $fullPublicId = trim($folder . '/' . $publicId, '/');

                cloudinary()->uploadApi()->destroy($fullPublicId);
            } catch (\Exception $e) {
                // Don't block deletion if Cloudinary cleanup fails
            }
        }

        $product->delete();
        return redirect('/admin/products')->with('success', 'Product Deleted');
    }

    // =========================
    // 📋 ORDERS SECTION
    // =========================

    public function orders()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $order         = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return back()->with('success', 'Order status updated');
    }

    public function cancelOrder(int $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $order         = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();
        return back()->with('success', 'Order cancelled');
    }

    // =========================
    // 👤 ADMINS SECTION
    // =========================

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
