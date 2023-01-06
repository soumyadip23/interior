<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
       'user_id', 'device_id', 'restaurant_id', 'product_id', 'product_name', 'product_image', 'price', 'quantity', 'is_cutlery_required', 'cutlery_quantity', 'cutlery_price'
    ];
}
