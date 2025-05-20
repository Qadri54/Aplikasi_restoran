<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Table;
use NumberFormatter;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller {
    public function meja(Table $table) { //mengirim data yang sudah dipesan dan di kirim ke halaman chekout
        $data_order = Order::with(['products', 'table'])->where('table_id', $table->id)->get();
        $rupiahFormaterr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $total_amount = 0;
        $final_amount = 0;
        $data_status = [];
        $transaction_id = Str::uuid();
        foreach ($data_order as $value) {
            foreach ($value->products as $product) {
                if ($value->status === 'pending') {
                    $total_amount += $product->harga * $product->pivot->quanity;
                }

                if ($value->status === 'done') {
                    $final_amount += $product->harga * $product->pivot->quanity;
                }

                $data_status[] = [
                    "nomor_meja" => $value->table->no_meja,
                    "nama_pesanan" => $product->nama_produk,
                    "jumlah" => $product->pivot->quanity,
                    "category" => $product->category->nama_category,
                    "harga" => $rupiahFormaterr->formatCurrency($product->harga, 'IDR'),
                    "total_harga" => $rupiahFormaterr->formatCurrency($product->harga * $product->pivot->quanity, 'IDR'),
                    "status" => $value->status,
                    "id" => $value->id
                ];
            }
        }
        return view('chekout', [
            "orders" => $data_status,
            "rupiahFormater" => $rupiahFormaterr,
            "no_meja" => $table->no_meja,
            "total_amount" => $total_amount,
            "transaction_id" => $transaction_id,
            "final_amount" => $final_amount
        ]);
    }

    // membuat function keranjang untuk fitur keranjang
    public function cart(Request $request){
        $validated = $request->validate([
            'id_product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // 1.buat variabel yang menampung data cookie lama
        $cookie_lama = Cookie::get('keranjang');

        // 2. masukkan data cookie lama ke dalam array (jika ada)
        $keranjang = $cookie_lama ? json_decode($cookie_lama, true) : [];

        // 3. masukkan data cookie baru kedalam array
        $keranjang[] = $validated;

        Cookie::queue('keranjang', json_encode($keranjang), 120);

        return redirect()->back();
    }

    public function set_meja(Request $request) {

        $validated = $request->validate([
            'no_meja' => 'required|exists:tables,no_meja|numeric'
        ]);

        Cookie::queue('no_meja', $validated['no_meja'], 60);

        return redirect()->route('meja', ['table' => $validated['no_meja']]);
    }

    public function cancelOrder(Request $request) {
        if ($request['status'] === 'pending') {
            Order::destroy($request['id']);
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'id_product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
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


    public function cetak(Request $request) {

        $rupiahFormaterr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $products = explode(',', $request['product_name']);
        $qty = explode(',', $request['number_of_orders']);
        $total_qty = array_sum($qty);
        $final_amount = $request['final_amount'];
        $nomor_meja = $request['nomor_meja'];
        $rupiahFormaterr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $final_amount = $rupiahFormaterr->formatCurrency($final_amount, 'IDR');
        // dd($products, $qty, $total_qty , $final_amount, $nomor_meja);

        $pdf = Pdf::loadView('laporan', compact('products','qty', 'total_qty','final_amount', 'nomor_meja'));

        return $pdf->download("struk meja $nomor_meja.pdf");
    }

}
