<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index'])->name('products.index');

    Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('cart/remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('cart/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'handleCheckout'])->name('checkout');
    Route::post('/paywith', [App\Http\Controllers\PaymentController::class, 'handlePaymentMethod'])->name('payment.method');

    Route::post('/pay', [App\Http\Controllers\PaymentController::class, 'store'])->name('payment.process');
    Route::get('/pay/complete/{id}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment.complete');
});
