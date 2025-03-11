<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Table;
use NumberFormatter;
use App\Models\Order;
use function Laravel\Prompts\table;

class OrderController extends Controller {
    public function meja(Table $table){
        $data_order = Order::with(['table', 'products'])->where('table_id',$table->id)->get();
        $rupiahFormaterr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $data_status = [];
        foreach($data_order as $value){
            foreach($value->products as $product){
                $data_status[] = [
                    "nomor_meja" =>$value->table->no_meja,
                    "nama_pesanan" =>$product->nama_produk,
                    "jumlah" =>$product->pivot->quanity,
                    "harga" =>$rupiahFormaterr->formatCurrency($product->harga,'IDR'),
                    "total_harga" =>$rupiahFormaterr->formatCurrency($product->harga * $product->pivot->quanity,'IDR'),
                    "status" =>$value->status
                ];
            }
        }
        return view('chekout', [
            "orders" => $data_status,
            "rupiahFormater" => $rupiahFormaterr,
            "no_meja" => $table->no_meja
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
