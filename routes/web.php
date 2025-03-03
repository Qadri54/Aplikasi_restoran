<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('admin', [ProductController::class,'get_all_admin']);

Route::get('/', [ProductController::class,'get_all']);

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/chekout', function () {
    return view('chekout');
});
