<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    protected $table = 'orderitems';

    protected $fillable = [
       'order_id', 'product_name', 'product_image', 'price', 'quantity'
    ];
}
