<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'status',
        'table_id',
        'user_id',
        'order_code'
    ];

    

    public function products():BelongsToMany{
        return $this->belongsToMany(
            product::class,'product_orders','id_order', 'id_product'
        )->withPivot('quanity');
    }  

    public function table():BelongsTo{
        return $this->belongsTo(Table::class,'table_id');
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }
}
