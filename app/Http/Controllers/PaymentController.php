<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Order;

class PaymentController extends Controller {

    public function index(Request $request) {

        $mytoken = base64_encode(config('app.server_key.sanbox'));
        $order_id = "ORDER-" . $request["order_midtrans_id"];
        $amount = $request["amount"];
        $id_meja = $request["id"];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $mytoken,
            ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', [
                        "transaction_details" => [
                            "order_id" => $order_id,
                            "gross_amount" => (int) $amount
                        ],
                        'callbacks' => [
                            'finish' => url("checkout/$id_meja"),
                        ],
                    ]);

            //mengecek status dari midtrans

            if (!$response->successful()) { //jika transaksi gagal
                return view('error', [
                    'error_message' => 'Transaksi gagal: ' . $response->json('status_message')
                ]);
            }

            $result = $response->json();

            return redirect($result['redirect_url']); //jika transaksi berhasil
            // dd($order_id);

        } catch (\Exception $e) { //jika terjadi error yang menyebabkan exception
            \Log::error($e->getMessage());
            return view('error', [
                'error_message' => "terjadi kesalahan dalam memproses transaksi"
            ]);
        }
    }

    /**
     * Checks the transaction status of a payment request.
     *
     * This function evaluates the transaction status provided in the request.
     * If the transaction status is "settlement", it indicates that the payment
     * has been successfully completed.
     *
     * The function is intended to interact with the payment gateway to verify
     * the current status of a transaction based on the order ID.
     *
     * @param Request $request The incoming HTTP request containing the 
     * transaction details, including the 'status_transaction' field.
     * @return mixed Returns the transaction status or an error view in case of
     * processing failure.
     */

    public function cekstatus(Request $request) {
        if ($request["status_transaction"] === "settlement") {

            //mengambil data yang sudah dikirim
            $table_id = $request->input('table_id');
            $products_names = $request->input('product_names'); // array
            $number_of_orders = $request->input('number_of_orders'); // array
            Order::where('table_id', $table_id)
                ->update(['status' => 'processing']);


            foreach ($products_names as $index => $product_name) {
                $product = Product::where('nama_produk', $product_name)->firstOrFail();
                $product->stok -= $number_of_orders[$index];
                $product->save();
            }

            return response()->json(['success' => 'Stok berhasil dikurangi.']);
        } else {
            return response()->json(['fail' => 'Gagal melakukan pengurangan stok.']);
        }
    }


}
