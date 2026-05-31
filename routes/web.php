<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test1', [ProductController::class, 'test1']);
Route::get('/test2', [ProductController::class, 'test2']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::get('/test1', [ProductController::class, 'test1'])->name('test1');
    Route::get('/test2', [ProductController::class, 'test2'])->name('test2');
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

Route::prefix('admin')->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('product', ProductController::class);
    Route::resource('user', UserController::class);
    Route::resource('post', PostController::class);
});
