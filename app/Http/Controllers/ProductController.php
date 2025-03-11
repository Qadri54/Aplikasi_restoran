<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Table;
use NumberFormatter;
class ProductController extends Controller
{
    public function get_all(Table $table) {
        $items = Product::all();
        $rupiahFormaterr = new NumberFormatter('id_ID',NumberFormatter::CURRENCY);
        $getpriceList = [];
        foreach($items as $item){
            $priceList = $item['harga'];   
            $formatPrice = $rupiahFormaterr->formatCurrency($priceList,'IDR');
            $getpriceList[] = $formatPrice;
        }
        return view('order',[
            'data'=> $items,
            'price' => $getpriceList,
            'no_meja' => $table->no_meja
        ]);
    }

    public function get_all_admin() {
        $items = Product::all();
        $rupiahFormaterr = new NumberFormatter('id_ID',NumberFormatter::CURRENCY);
        $getpriceList = [];
        foreach($items as $item){
            $priceList = $item['harga'];   
            $formatPrice = $rupiahFormaterr->formatCurrency($priceList,'IDR');
            $getpriceList[] = $formatPrice;
        }
        return view('product-list',[
            'data'=> $items,
            'price' => $getpriceList
        ]);
    }
}
