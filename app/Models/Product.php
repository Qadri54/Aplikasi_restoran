<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model {
    protected $fillable = [
        'nama_produk',
        'stok',
        'harga',
        'category_id'
    ];

    public function category():BelongsTo {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function order():BelongsToMany{
        return $this->belongsToMany(Order::class,'product_orders','id_product', 'id_order');
    }
}
