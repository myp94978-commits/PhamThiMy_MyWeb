<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Client Product Routes (without prefix)
Route::get('/product', [ClientProductController::class, 'index'])->name('product.index');
Route::get('/product/{slug}', [ClientProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [ClientProductController::class, 'category'])->name('products.category');
Route::get('/brand/{slug}', [ClientProductController::class, 'brand'])->name('product.brand');
Route::get('/search', [ClientProductController::class, 'search'])->name('product.search');
Route::get('/contact', function () {
    return view('client.contact.index');
})->name('contact');

// Client Cart Routes (without prefix)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/api/orders', [CartController::class, 'storeOrder'])->name('cart.storeOrder');

Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postForgotPassword'])->name('forgotpass.post');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset.post');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [AuthController::class, 'postChangePassword'])->name('change-password.post');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/test1', [AdminProductController::class, 'test1'])->name('test1');
        Route::get('/test2', [AdminProductController::class, 'test2'])->name('test2');

        // CRUD - Resource route
        Route::middleware('roles:1')->group(function () {
            // Restore and force-delete routes for soft-deleted categories
            Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])
                ->name('categories.restore');

            // Restore all / Force delete all
            Route::patch('categories/restore-all', [CategoryController::class, 'restoreAll'])
                ->name('categories.restoreAll');

            Route::delete('categories/forcedelete-all', [CategoryController::class, 'forceDeleteAll'])
                ->name('categories.forceDeleteAll');

            Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])
                ->name('categories.forceDelete');

            // Soft delete trash route
            Route::get('trash/categories', [CategoryController::class, 'trash'])
                ->name('categories.trash');
            Route::resource('categories', CategoryController::class);
            Route::resource('brand', BrandController::class);
            Route::delete('product/{product}/images/{image}', [AdminProductController::class, 'destroyImage'])
                ->name('product.images.destroy');
            // full product resource for admin (role 1)
            Route::resource('product', AdminProductController::class)->except(['index']);
            Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
            Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
                ->name('orders.status');
            Route::resource('user', UserController::class);
            Route::resource('post', PostController::class);
        });

        // Allow role 1 (admin) and role 2 (user) to access product index
        Route::resource('product', AdminProductController::class)->only(['index'])->middleware('roles:1,2');
    });
});

Route::get('/test', function () {
  return view('admin.layout.admin');
});
Route::get('/admin/test', [UserController::class, 'test']);

Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{param1}/{param2}', [DemoController::class, 'index6']);

// (debug route removed)

// (temporary debug route removed)
