<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

    class TestController extends Controller {
        public function index(Request $request) {

            $mytoken = base64_encode(config('app.server_key.sanbox'));
            $order_id = "ORDER-".$request["id"];
            $amount = $request["amount"];

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $mytoken,
            ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', [
                        "transaction_details" => [
                            "order_id" => $order_id,
                            "gross_amount" => (int)$amount
                        ]
                    ]);
                    $result = $response->json();
                    return  redirect($result['redirect_url']);
                    // dd($result);

        }
}
