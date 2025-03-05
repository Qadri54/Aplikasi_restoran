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
        $rupiahFormaterr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);

        return view('chekout', [
            "orders" => $orders,
            "rupiahFormater" => $rupiahFormaterr,
        ]);
    }

    public function store(Request $request) {
        // Validasi input
        $validated = $request->validate([
            'id_product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);


        // 1. Buat order baru dan simpan di variable
        $order = Order::create([
            'table_id' => $request->table_id,  // kalau ada table_id
            'status' => 'pending'
        ]);

        $order->products()->attach($validated['id_product'], [
            'quanity' => $validated['quantity']
        ]);
        return redirect()->back()->with('success', 'Order berhasil ditambahkan!');
    }
}
