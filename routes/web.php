<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductRequestController;

// ============================
// FRONTEND
// ============================
Route::get('/', [HomeController::class, 'index']);
Route::get('/products', [HomeController::class, 'products']);
Route::get('/add-to-cart/{id}', [CartController::class, 'add']);
Route::get('/remove-from-cart/{id}', [ProductController::class, 'removeFromCart']);
Route::get('/cart', function () { return view('cart'); });
Route::get('/checkout', function () { return view('checkout'); });
Route::post('/place-order', [OrderController::class, 'store']);

Route::get('/product-lists/create', [ProductRequestController::class, 'create'])->name('product-lists.create');
Route::post('/product-lists/store', [ProductRequestController::class, 'store'])->name('product-lists.store');
Route::get('/product-lists/history', [ProductRequestController::class, 'history'])->name('product-lists.history');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    Auth::login($user);

    return redirect()->route('product-lists.history')->with('success', 'Account created successfully.');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('product-lists.history'));
    }

    return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
});
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'You have been logged out.');
})->name('logout');

// ✅ NEW: Product image route - serve images from database
Route::get('/product-image/{imageId}', [ProductImageController::class, 'show'])->name('product.image');

// ADMIN
// ============================
Route::get('/admin', function () { return redirect('/admin/login'); });
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/product-lists', [AdminController::class, 'productLists']);
    Route::post('/business-profile', [AdminController::class, 'updateBusinessProfile']);
    Route::post('/product-lists/{id}/review', [AdminController::class, 'reviewProductList']);
    Route::post('/product-lists/{id}/reply', [AdminController::class, 'replyToProductList']);

    // Products
    Route::get('/products', [AdminController::class, 'products']);
    Route::get('/products/create', [AdminController::class, 'create']);
    Route::post('/products/store', [AdminController::class, 'store']);
    Route::get('/products/edit/{id}', [AdminController::class, 'edit']);
    Route::put('/products/update/{id}', [AdminController::class, 'update']);
    Route::get('/products/delete/{id}', [AdminController::class, 'delete']);

    // Categories  ← removed wrong /admin prefix
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Orders
    Route::get('/orders', [AdminController::class, 'orders']);
    Route::post('/order/{id}/status', [AdminController::class, 'updateOrderStatus']);
    Route::post('/order/{id}/cancel', [AdminController::class, 'cancelOrder']);

    // Manage admins
    Route::get('/admins', [AdminController::class, 'admins']);
    Route::post('/admins', [AdminController::class, 'createAdmin']);
    Route::delete('/admins/{id}', [AdminController::class, 'destroyAdmin']);
});

Route::get('/help', [HelpController::class, 'index'])->name('help');
Route::post('/help/send', [HelpController::class, 'send'])->name('help.send');

Route::get('/return', function () {
    return view('return');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/privacy', function () {
    return view('privacy');
});

//check users
Route::get('/check-user', function () {
    $user = App\Models\User::where('email', 'delfinusideusdedith@gmail.com')->first();
    return $user;
});
