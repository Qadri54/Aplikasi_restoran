<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use NumberFormatter;
class ProductController extends Controller
{
    public function get_all() {
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
            'price' => $getpriceList
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
