<?php

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

    Route::get('/checkout', [App\Http\Controllers\PaymentController::class, 'create'])->name('checkout');
    Route::post('/pay', [App\Http\Controllers\PaymentController::class, 'store'])->name('payment.process');
});
