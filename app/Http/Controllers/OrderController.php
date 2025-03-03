<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use NumberFormatter;
use App\Models\Order;

class OrderController extends Controller {
    public function index() {
        $orders = Order::with(['table', 'products'])
            ->where('table_id', 1)
            ->get();
        foreach ($orders as $order) {
            echo "Order ID: {$order->id} - Nomor Meja: {$order->table->no_meja}<br>";
            foreach ($order->products as $product) {
                echo "Produk: {$product->nama_produk}, Quantity: {$product->pivot->quanity}<br>";
            }
            echo "<hr>";
        }
    }
}
