<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

Route::middleware(['auth'])->group(function(){
    Route::get('/admin', [ProductController::class, 'get_all_admin'])->name('admin');
});

Route::get('/', function () {
    return view('home');
});

Route::get('/showAdminLogin', [AuthController::class, 'showLogin'])->name('login');
Route::get('/showregister', [AuthController::class, 'showRegister'])->name('show.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login',[AuthController::class,'login'])->name('auth.login');
Route::post('/logout',[AuthController::class,'logout'])->name('auth.logout');

Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/meja/{table:no_meja}', [ProductController::class, 'get_all']);
Route::get('/checkout/{table:no_meja}', [OrderController::class, 'meja']);