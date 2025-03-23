<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_customer',
        'address',
        'total_price',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(Order_item::class, 'order_id');
    }
}
