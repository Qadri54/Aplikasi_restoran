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

    public function update(Request $request,$nama_produk) {
        $validated = $request->validate([
        'nama_produk' => 'required|max:50',
        'category' => 'required|numeric|exists:categories,id',
        'stok' => 'required|min:1',
        'harga' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $product = Product::where('nama_produk', $nama_produk)->firstOrFail();

    // Jika ada file gambar baru
    if ($request->hasFile('image')) {
        $uploadedFile = $request->file('image');
        $Raw_path = $uploadedFile->store('public/images');
        $final_path = str_replace('public/', '', $Raw_path);
        $path = str_replace('images/', '', $final_path);
        $product->image = $path;
    }

    // Update data lainnya
    $product->nama_produk = $validated['nama_produk'];
    $product->category_id = $validated['category'];
    $product->stok = $validated['stok'];
    $product->harga = $validated['harga'];

    $product->save();

    return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'nama_produk' => 'required|max:50',
            'category' => 'required|numeric|exists:categories,id',
            'stok' => 'required|min:1',
            'harga' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $uploadedFile = $request->file('image');
        $rawpath = $uploadedFile->store('public/images');

        $explode_file = explode('/', $rawpath);

        $path = $explode_file[2];


        Product::create([
            'nama_produk' => $validated['nama_produk'],
            'category_id' => $validated['category'],
            'stok' => $validated['stok'],
            'harga' => $validated['harga'],
            'image' => $path,
        ]);

        return redirect()->back();
    }
}
