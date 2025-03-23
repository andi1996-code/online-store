<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
