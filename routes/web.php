<?php

use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TetimonialController;
use App\Http\Controllers\Admin\OrderController as OrderAdminController;
use App\Http\Controllers\Admin\WebsettingController;
use App\Http\Controllers\users\CartController;
use App\Http\Controllers\users\NewsController as UsersNewsController;
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

Route::get('/berita', [UsersNewsController::class, 'index'])->name('news-view.index');
Route::get('/berita/detail/{slug}', [UsersNewsController::class, 'detail'])->name('news-view.detail');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::resource('cart', CartController::class);
    Route::get('/cart-count', [CartController::class, 'countCart'])->name('getCartCount');
    Route::get('/cart-total-price', [CartController::class, 'getTotalPrice'])->name('getTotalPrice');
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'detail']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'role']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('products', ProductController::class);
    Route::patch('/product-status/{id}', [ProductController::class, 'updateStatus'])->name('product-status.update');
    Route::delete('/product-image/{id}', [ProductController::class, 'deleteImage'])->name('product-image.delete');
    Route::resource('order', OrderAdminController::class);
    Route::patch('/order-status/{id}', [OrderAdminController::class, 'updateStatus'])->name('order-status.update');
    Route::resource('users/admin', UserController::class);
    Route::resource('users/client', UserController::class);
    Route::patch('users/admin-status/{id}', [UserController::class, 'updateStatus'])->name('admin.status-update');
    Route::patch('users/client-status/{id}', [UserController::class, 'updateStatus'])->name('client.status-update');
    Route::resource('testimonial', TetimonialController::class);
    Route::resource('news', NewsController::class);
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company-profile');
    Route::post('/company-profile', [CompanyProfileController::class, 'store'])->name('company-profile.store');
    Route::get('web-settings', [WebsettingController::class, 'index'])->name('web-settings');
    Route::post('web-settings', [WebsettingController::class, 'store'])->name('web-settings.store');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/profile', [UserController::class, 'index']);
});
