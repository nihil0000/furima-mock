<?php

use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;

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

// Auth
Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login.create'); // display login form
    Route::post('/login', 'store')->name('login.store'); // authentication (login)
    Route::post('/logout', 'destroy')->name('logout.destroy'); // logout
});

// Register
Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create')->name('register.create'); // display register form
    Route::post('/register', 'store')->name('register.store');  // register
});

// Profile
Route::middleware('auth')
    ->controller(ProfileController::class)
    ->group(function () {
        Route::get('/mypage', 'show')->name('profile.show'); // display the profile
        Route::get('/mypage/profile', 'edit')->name('profile.edit');  // display to edit　the profile
        Route::post('/mypage', 'store')->name('profile.store');  // register　the profile
});

// Product
Route::controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('product.index'); // display the product list
    Route::get('/product/{product}', 'show')->name('product.show'); // display details of product

    Route::middleware('auth')->group(function () {
        Route::get('/exhibit', 'create')->name('product.create'); // exhibit product
        Route::post('/exhibit', 'store')->name('product.store'); // register product
    });
});

// Favorite
Route::middleware('auth')
    ->controller(FavoriteController::class)
    ->group(function () {
        Route::post('/favorite/{product}', 'store')->name('favorite.store');
        Route::delete('/favorite/{product}', 'destroy')->name('favorite.destroy');
});

// Comment
Route::middleware('auth')->group(function () {
    Route::post('/comment/{product}', [CommentController::class, 'store'])->name('comment.store');
});

// Purchase
Route::middleware('auth')
    ->controller(PurchaseController::class)
    ->group(function () {
        Route::get('/purchase/address/{product}', 'create')->name('purchase.create');
        Route::post('/purchase/address/update/{product}', 'update')->name('purchase.update');
        Route::get('/purchase/{product}', 'show')->name('purchase.show');
        Route::post('/purchase/{product}', 'store')->name('purchase.store');
});
