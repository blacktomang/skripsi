<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\users\ProfileController;
use App\Http\Controllers\ViewController;
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

// Route::get('/', function () {
//     return view('pages.main.index');
// });

// Route::group(function(){
    Route::get('/', [ViewController::class, 'home']);
    Route::get('/produk', [ViewController::class, 'products']);
    Route::get('/produk/detail/{slug}', [ViewController::class, 'productDetail'])->name('product-detail');
// });

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index']);
});

Route::group(['prefix' => 'dashboard','middleware' => ['auth', 'role']], function () {
    // Route::get('/', [DashboardController::class, 'index']);
    Route::resource('products', ProductController::class);
    Route::patch('/product-status/{id}', [ProductController::class, 'updateStatus'])->name('product-status.update');
    Route::delete('/product-image/{id}', [ProductController::class, 'deleteImage'])->name('product-image.delete');
    Route::resource('users/admin', UserController::class);
    Route::resource('users/client', UserController::class);
});

Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/profile', [UserController::class, 'index']); 
});
