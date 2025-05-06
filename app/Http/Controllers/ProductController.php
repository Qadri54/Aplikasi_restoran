<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Table;
use NumberFormatter;

class ProductController extends Controller {
    public function get_all(Table $table = null) {
        $items = Product::with('category')->get();
        $rupiahFormaterr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $getpriceList = [];

        foreach ($items as $item) {
            $priceList = $item['harga'];
            $formatPrice = $rupiahFormaterr->formatCurrency($priceList, 'IDR');
            $getpriceList[] = $formatPrice;
        }

        if ($table) {
            return view('order', [
                'data' => $items,
                'price' => $getpriceList,
                'no_meja' => $table->no_meja
            ]);
        }

        if (request()->is('admin')) {
            return view('product-list');
        }

        return json_encode([
            'data' => $items,
        ]);
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->back();
    }

    public function update(Request $request) {
        $product = Product::where('nama_produk', $request->nama_produk)->first();
        $product->nama_produk = $request->nama_produk;
        $product->category_id = $request->category;
        $product->stok = $request->stok;
        $product->harga = $request->harga;
        $product->save();
        return redirect()->back();
    }

    public function create(Request $request) {
        $product = new Product();
        $product->nama_produk = $request->nama_produk;
        $product->category_id = $request->category;
        $product->stok = $request->stok;
        $product->harga = $request->harga;
        $product->save();
        return redirect()->back();
    }
}
