<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTiming extends Model
{
    protected $table = 'restaurant_timings';

    protected $fillable = [
       'resturant_id', 'start_time', 'end_time', 'day'
    ];
}
