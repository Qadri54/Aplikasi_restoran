<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;

//website utama
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [ProductController::class, 'get_all'])->name('admin');
    });

    Route::get('/', function () {
        return view('home');
    });

    Route::get('/showAdminLogin', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/showregister', [AuthController::class, 'showRegister'])->name('show.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/meja/{table:no_meja}', [ProductController::class, 'get_all']);
    Route::get('/checkout/{table:no_meja}', [OrderController::class, 'meja'])->name("checkout");
    Route::post('/delete_order', [OrderController::class, 'cancelOrder'])->name('delete_order');
    
    
    Route::get('/kasir', function () {
        return view('kasir');
    });

    Route::post('/payment', [PaymentController::class, 'index'])->name('payment');

    //crud product
    Route::get('/allproduct', [ProductController::class, 'get_all'])->name("produk");
    Route::get('/delete/{product:id}', [ProductController::class, 'destroy'])->name("delete_product");
    Route::post('/edit/{product:nama_produk}', [ProductController::class, 'update'])->name("edit_product");
    Route::post('/add', [ProductController::class, 'create'])->name("add_product");


    Route::post('/payment/cekstatus', [PaymentController::class, 'cekstatus'])->name('payment.cekstatus');
    Route::get('/payment/cekstatus', function () {
        return view('cekstatsuBayar'); //menuju ke halaman cek status (untuk debugging)
    });

