<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('items', '\App\Http\Controllers\ItemController');
    Route::resource('categories', '\App\Http\Controllers\CategoryController');
});
Route::resource('products', '\App\Http\Controllers\ProductController');
//Route::resource('cart', '\App\Http\Controllers\ProductController');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products/{id}', [App\Http\Controllers\CategoryController::class, 'chosenCategory'])->name('chosenCategory');
Route::get('/add-to-cart/{id}', [App\Http\Controllers\ProductController::class, 'addToCart'])->name('addToCart');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::put('/cart/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/check_order', [App\Http\Controllers\CartController::class, 'checkOrder'])->name('check_order');

Route::get('/admin/orders', 'Admin\OrderController@index')->name('admin.orders');
