<?php

use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TetimonialController;
use App\Http\Controllers\users\CartController;
use App\Http\Controllers\users\OrderController;
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

    Route::get('/', [ViewController::class, 'home']);
    Route::get('/product', [ViewController::class, 'products']);
    Route::get('/product/detail/{slug}', [ViewController::class, 'productDetail'])->name('product-detail');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::resource('cart', CartController::class);
    Route::get('/cart-count', [CartController::class, 'countCart'])->name('getCartCount');
    Route::get('/cart-total-price', [CartController::class, 'getTotalPrice'])->name('getTotalPrice');
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'detail']);
    Route::post('/checkout', [OrderController::class, 'checkout']);

});

Route::group(['prefix' => 'dashboard','middleware' => ['auth', 'role']], function () {
    Route::resource('products', ProductController::class);
    Route::patch('/product-status/{id}', [ProductController::class, 'updateStatus'])->name('product-status.update');
    Route::delete('/product-image/{id}', [ProductController::class, 'deleteImage'])->name('product-image.delete');
    Route::resource('users/admin', UserController::class);
    Route::resource('users/client', UserController::class);
    Route::resource('testimonial', TetimonialController::class);
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company-profile');
    Route::post('/company-profile', [CompanyProfileController::class, 'store'])->name('company-profile.store');
});

Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/profile', [UserController::class, 'index']); 
});
