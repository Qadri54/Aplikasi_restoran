<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Table;
use NumberFormatter;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller {
    public function meja(Table $table) { //mengirim data yang sudah dipesan dan di kirim ke halaman chekout
        $data_order = Order::with(['products','table'])->where('table_id',$table->id)->get();
        $rupiahFormaterr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $total_amount = 0;
        $data_status = [];
        $transaction_id = Str::uuid();
        foreach($data_order as $value){
            foreach($value->products as $product){
                if($value->status === 'pending'){
                    $total_amount += $product->harga * $product->pivot->quanity;
                }
                $data_status[] = [
                    "nomor_meja" =>$value->table->no_meja,
                    "nama_pesanan" =>$product->nama_produk,
                    "jumlah" =>$product->pivot->quanity,
                    "category" => $product->category->nama_category,
                    "harga" =>$rupiahFormaterr->formatCurrency($product->harga,'IDR'),
                    "total_harga" =>$rupiahFormaterr->formatCurrency($product->harga * $product->pivot->quanity,'IDR'),
                    "status" =>$value->status,
                    "id" =>$value->id
                ];
            }
        }
        return view('chekout', [
            "orders" => $data_status,
            "rupiahFormater" => $rupiahFormaterr,
            "no_meja" => $table->no_meja,
            "total_amount" => $total_amount,
            "transaction_id" => $transaction_id
        ]);
    }

    public function cancelOrder(Request $request){
        if($request['status'] === 'pending'){
            Order::destroy($request['id']);
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'id_product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

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
