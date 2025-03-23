<?php

use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;

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

// auth
Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login.create'); // display login form
    Route::post('/login', 'store')->name('login.store'); // authentication (login)
    Route::post('/logout', 'destroy')->name('logout.destroy'); // logout
});

// register
Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create')->name('register.create'); // display register form
    Route::post('/register', 'store')->name('register.store');  // register
});

// profile
Route::middleware('auth')
    ->controller(ProfileController::class)
    ->group(function () {
        Route::get('/mypage', 'show')->name('profile.show'); // display the profile
        Route::get('/mypage/profile', 'edit')->name('profile.edit');  // display to edit　the profile
        Route::post('/mypage', 'store')->name('profile.store');  // register　the profile
});

// product
Route::controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('product.index'); // display the product list
    Route::get('/product/{product}', 'show')->name('product.show'); // display details of product

    Route::middleware('auth')->group(function () {
        Route::get('/exhibit', 'create')->name('product.create'); // exhibit product
        Route::post('/exhibit', 'store')->name('product.store'); // register product
    });
});

// purchase
Route::middleware('auth')
    ->controller(PurchaseController::class)
    ->group(function () {
        Route::get('/purchase/address/{product_id}', 'create')->name('purchase.create');
        Route::get('/purchase/{product}', 'show')->name('purchase.show');
        Route::post('/purchase', 'update')->name('purchase.update');
});


