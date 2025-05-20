<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_order extends Model
{
    protected $fillable = [
        'id_product',
        'id_order',
        'order_code',
    ];
}
