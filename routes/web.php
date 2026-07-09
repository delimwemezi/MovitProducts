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

// ✅ NEW: Product image route - serve images from database
Route::get('/product-image/{imageId}', [ProductImageController::class, 'show'])->name('product.image');

// ============================
// DIAGNOSTIC ROUTES (TEMPORARY)
// ============================
Route::get('/debug/products', function () {
    $products = \App\Models\Product::with('primaryImage')->limit(10)->get();
    return response()->json([
        'total_products' => \App\Models\Product::count(),
        'total_images' => \App\Models\ProductImage::count(),
        'products' => $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'has_primary_image' => $p->primaryImage ? true : false,
                'image_id' => $p->primaryImage?->id,
                'image_size' => $p->primaryImage?->file_size,
                'mime_type' => $p->primaryImage?->mime_type,
                'image_url' => $p->primaryImage ? route('product.image', $p->primaryImage->id) : null,
            ];
        }),
    ]);
});

Route::get('/debug/images', function () {
    $images = \App\Models\ProductImage::limit(10)->get();
    return response()->json([
        'total_images' => \App\Models\ProductImage::count(),
        'images' => $images->map(function ($img) {
            return [
                'id' => $img->id,
                'product_id' => $img->product_id,
                'file_size' => $img->file_size,
                'mime_type' => $img->mime_type,
                'original_filename' => $img->original_filename,
                'data_length' => strlen($img->image_data),
                'is_cloudinary' => $img->is_cloudinary,
            ];
        }),
    ]);
});

// ADMIN
// ============================
Route::get('/admin', function () { return redirect('/admin/login'); });
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

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

