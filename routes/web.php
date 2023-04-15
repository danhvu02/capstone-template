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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products/{id}', [App\Http\Controllers\CategoryController::class, 'chosenCategory'])->name('chosenCategory');
