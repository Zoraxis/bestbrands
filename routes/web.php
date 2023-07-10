<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index'])->name('products');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index']);
Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'index']);

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::get('/ajax/profile/out', [App\Http\Controllers\Ajax\ProfileController::class, 'out']);
Route::get('/ajax/profile/get', [App\Http\Controllers\Ajax\ProfileController::class, 'get']);
Route::get('/ajax/profile/edit', [App\Http\Controllers\Ajax\ProfileController::class, 'edit']);
Route::get('/ajax/general/set', [App\Http\Controllers\Ajax\GeneralController::class, 'set']);

Route::get('/ajax/api/get', [App\Http\Controllers\Ajax\APIController::class, 'get']);

Route::get('/products/{id}', [App\Http\Controllers\OneProductController::class, 'index'])->name('oneproduct');

Route::get('/', [App\Http\Controllers\ProductsController::class, 'index']);

Route::get('/addprod', [App\Http\Controllers\AddProduct::class, 'index']);
Route::post('/img-upload', [App\Http\Controllers\ImageController::class, 'storeImage'])->name('image.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
