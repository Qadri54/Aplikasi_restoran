<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Table;
use NumberFormatter;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class OrderController extends Controller {
    public function checkout($table_id, $user_id) {

        // Ambil semua data orders dan relasi menggunakan Query Builder
        $orders = DB::table('orders')
            ->join('product_orders', 'orders.id', '=', 'product_orders.id_order')
            ->join('products', 'products.id', '=', 'product_orders.id_product')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('tables', 'tables.id', '=', 'orders.table_id')
            ->where('orders.user_id', $user_id)
            ->where('orders.table_id', $table_id)
            ->select(
                'orders.id as order_id',
                'orders.status',
                'tables.no_meja',
                'products.nama_produk',
                'products.harga',
                'product_orders.quanity',
                'categories.nama_category'
            )
            ->get();

        $rupiahFormaterr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);

        $total_amount = 0;
        $final_amount = 0;
        $data_status = [];
        $transaction_id = Str::uuid();

        foreach ($orders as $order) {
            $sub_total = $order->harga * $order->quanity;

            if ($order->status === 'pending') {
                $total_amount += $sub_total;
            }

            if ($order->status === 'done') {
                $final_amount += $sub_total;
            }

            $data_status[] = [
                "nomor_meja" => $order->no_meja,
                "nama_pesanan" => $order->nama_produk,
                "jumlah" => $order->quanity,
                "category" => $order->nama_category,
                "harga" => $rupiahFormaterr->formatCurrency($order->harga, 'IDR'),
                "total_harga" => $rupiahFormaterr->formatCurrency($sub_total, 'IDR'),
                "status" => $order->status,
                "id" => $order->order_id,
            ];
        }

        return view('chekout', [
            "orders" => $data_status,
            "rupiahFormater" => $rupiahFormaterr,
            "no_meja" => $table_id,
            "total_amount" => $total_amount,
            "user_id" => $user_id,
            "transaction_id" => $transaction_id,
            "final_amount" => $final_amount
        ]);
    }

    // membuat function keranjang untuk fitur keranjang
    public function cart(Request $request) {
        $validated = $request->validate([
            'id_product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'produk_name' => 'required'
        ]);

        // Ambil data cookie lama
        $cookie_lama = Cookie::get('keranjang');

        // Decode cookie lama jika ada, atau buat array kosong
        $keranjang = $cookie_lama ? json_decode($cookie_lama, true) : [];

        // Cek apakah produk sudah ada di keranjang
        $found = false;
        foreach ($keranjang as &$item) {
            if ($item['id_product'] == $validated['id_product']) {
                $item['quantity'] += $validated['quantity'];
                $item['produk_name'] = $validated['produk_name'];
                $found = true;
                break;
            }
        }
        unset($item); // penting setelah loop by reference

        // Jika belum ada, tambahkan produk baru ke keranjang
        if (!$found) {
            $keranjang[] = [
                'id_product' => $validated['id_product'],
                'quantity' => $validated['quantity'],
                'produk_name' => $validated['produk_name']
            ];
        }

        // Simpan kembali ke cookie
        Cookie::queue('keranjang', json_encode($keranjang), 60 * 24); // berlaku selama 1 hari

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function set_meja(Request $request) {

        $validated = $request->validate([
            'no_meja' => 'required|exists:tables,no_meja|numeric'
        ]);

        Cookie::queue('no_meja', $validated['no_meja'], 60);

        return redirect()->route('meja', ['table' => $validated['no_meja']]);
    }

    public function cancelOrder(Request $request) {
        if ($request['order_status'] === 'pending') {
            Order::destroy($request['order_id']);
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'table_id' => 'required|exists:tables,id',   // pastikan table_id dikirim
            'user_id' => 'required|exists:users,id',     // pastikan user_id dikirim
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        // Cari apakah ada order pending untuk user + meja yang sama
        $order = Order::firstOrCreate(
            [
                'user_id' => $validated['user_id'],
                'table_id' => $validated['table_id'],
                'status' => 'pending'
            ]
        );

        // Tambahkan produk ke order (pivot: product_orders)
        $order->products()->attach($validated['id_product'], [
            'quanity' => $validated['quantity']
        ]);

        return redirect()->back()->with('success', 'Order berhasil ditambahkan!');
    }


    public function cetak(Request $request) {
        // Ambil data dari form
        $products = explode(',', $request->product_name);
        $qty = array_map('intval', explode(',', $request->number_of_orders));
        $final_amount = floatval($request->final_amount);
        $nomor_meja = $request->nomor_meja;

        // Simulasi harga satuan tiap produk (biasanya ambil dari database)
        // Misalnya semua produk harganya 20.000, 25.000, dst.
        $prices = [];
        foreach ($products as $index => $item) {
            $prices[$index] = 20000 + ($index * 5000); // contoh simulasi harga
        }

        // Hitung subtotal
        $subtotal_total = 0;
        foreach ($products as $i => $item) {
            $subtotal_total += $prices[$i] * $qty[$i];
        }

        // Diskon 10%
        $discount = 0.10;
        $discount_amount = $subtotal_total * $discount;

        // Pajak 11%
        $tax = 0.11 * ($subtotal_total - $discount_amount);

        // Total bayar
        $total_pay = $subtotal_total - $discount_amount + $tax;

        // Formatter untuk rupiah
        $rupiah = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);

        // Format tampilan rupiah
        $subtotal_total_fmt = $rupiah->formatCurrency($subtotal_total, 'IDR');
        $discount_amount_fmt = $rupiah->formatCurrency($discount_amount, 'IDR');
        $tax_fmt = $rupiah->formatCurrency($tax, 'IDR');
        $final_amount_fmt = $rupiah->formatCurrency($final_amount, 'IDR'); // dari input form
        $total_pay_fmt = $rupiah->formatCurrency($total_pay, 'IDR');

        // Kirim ke view laporan.blade.php
        $pdf = Pdf::loadView('laporan', [
            'products' => $products,
            'qty' => $qty,
            'prices' => $prices,
            'total_qty' => array_sum($qty),
            'subtotal_total' => $subtotal_total_fmt,
            'discount' => $discount_amount_fmt,
            'tax' => $tax_fmt,
            'final_amount' => $final_amount_fmt,
            'total_pay' => $total_pay_fmt,
            'nomor_meja' => $nomor_meja,
        ]);

        return $pdf->download("struk_meja_$nomor_meja.pdf");
    }


}
