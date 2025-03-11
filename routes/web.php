<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('admin', [ProductController::class,'get_all_admin']);

Route::get('/meja/{table:no_meja}', [ProductController::class,'get_all']);
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');


Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/chekout', function () {
    return view('chekout');
});

Route::get('/checkout/{table:no_meja}', [OrderController::class,'meja']);