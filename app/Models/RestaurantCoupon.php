<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantCoupon extends Model
{
    protected $table = 'restaurant_coupons';

    protected $fillable = [
       'restaurant_id', 'title', 'description', 'code', 'type', 'rate', 'maximum_offer_rate', 'start_date', 'end_date', 'maximum_time_of_use', 'maximum_time_user_can_use',  'status'
    ];
}
