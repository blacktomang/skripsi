<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
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

Route::get('/', function () {
    return view('pages.main.index');
});

Route::group(['prefix' => 'dashboard','middleware' => ['auth', 'role']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('products', ProductController::class);
    Route::delete('/product-image/{id}', [ProductController::class, 'delete_image'])->name('product-image.delete');
});
