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
        $rupiahFormaterr = new NumberFormatter('id_ID',NumberFormatter::CURRENCY);
        $totalPricing = 0;

        foreach ($orders as $order) {
            echo "Order ID: {$order->id} - Nomor Meja: {$order->table->no_meja}<br>";
            foreach ($order->products as $product) {
                $subTotal = $product->harga * $product->pivot->quanity;
                $totalPricing += $subTotal;
                echo "Produk: {$product->nama_produk}, Quantity: {$product->pivot->quanity}, harga qty: {$rupiahFormaterr->formatCurrency($product->harga,'IDR')}<br>";
            }
            echo "<hr>";
        }

        echo "Total harga: " . $rupiahFormaterr->formatCurrency($totalPricing,'IDR');
    }
}
