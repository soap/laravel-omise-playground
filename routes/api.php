<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::omiseWebhooks('oms/webhooks');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
