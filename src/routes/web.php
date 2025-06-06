<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\TradeMessageController;
use App\Http\Controllers\RatingController;

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

// Authentication (login, logout)
Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login.create'); // Display login form
    Route::post('/login', 'store')->name('login.store'); // Authentication (login)
    Route::post('/logout', 'destroy')->name('logout.destroy'); // Logout
});

// Register user
Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create')->name('register.create'); // Display register form
    Route::post('/register', 'store')->name('register.store');  // Register
});

// Profile
Route::middleware('auth')
    ->controller(ProfileController::class)
    ->group(function () {
        Route::get('/mypage', 'show')->name('profile.show'); // Display the profile
        Route::get('/mypage/profile', 'edit')->name('profile.edit');  // Display to edit　the profile
        Route::post('/mypage', 'store')->name('profile.store');  // Register　the profile
});

// Product
Route::controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('product.index'); // Display the product list
    Route::get('/product/{product}', 'show')->name('product.show'); // Display details of product

    Route::middleware('auth')->group(function () {
        Route::get('/exhibit', 'create')->name('product.create'); // Exhibit product
        Route::post('/exhibit', 'store')->name('product.store'); // Register product
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
        Route::post('/purchase/{product}/checkout-session', 'createCheckoutSession')->name('purchase.checkout-session');
        Route::get('/purchase/{product}/success', 'success')->name('purchase.success');
});

// Display email verification page
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Verify email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // verify
    return redirect()->route('product.index');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Send verification notification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Trade
Route::middleware('auth')->group(function () {
    Route::post('/trade/start/{product}', [TradeController::class, 'start'])->name('trade.start');
    Route::get('/trade/{trade}', [TradeController::class, 'show'])->name('trade.show');
    Route::post('/trade/{trade}/messages', [TradeMessageController::class, 'store'])->name('trade.messages.store');
    // マイページ
    Route::get('/mypage/trade', [TradeController::class, 'index'])->name('mypage.trade.index');

    Route::post('/trades/{trade}/complete', [TradeController::class, 'complete'])->name('trades.complete'); // 取引完了ルート
    Route::post('/trades/{trade}/ratings', [RatingController::class, 'store'])->name('trades.ratings.store'); // 評価保存ルート

    // Message
    Route::patch('/trade-message/{message}', [TradeMessageController::class, 'update'])->name('trade-message.update');
    Route::delete('/trade-message/{message}', [TradeMessageController::class, 'destroy'])->name('trade-message.destroy');
});

