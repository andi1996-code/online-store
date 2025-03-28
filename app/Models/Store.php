<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name_store',
        'address',
        'phone',
        'wa_order_template', // Custom WhatsApp message template
        'image',
        'description',
        'profile_picture'
    ];
}
