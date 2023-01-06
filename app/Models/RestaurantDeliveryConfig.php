<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantDeliveryConfig extends Model
{
    protected $table = 'restaurant_delivery_configs';

    protected $fillable = [
       'restaurant_id', 'delivery_type'
    ];
}
