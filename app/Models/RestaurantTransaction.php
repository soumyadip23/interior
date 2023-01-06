<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTransaction extends Model
{
    protected $table = 'restaurant_transactions';

    protected $fillable = [
       'restaurant_id', 'order_ref_id', 'amount', 'note', 'type'
    ];
}
