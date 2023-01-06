<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavouriteRestaurant extends Model
{
    protected $table = 'user_favourite_restaurants';

    protected $fillable = [
       'user_id', 'restaurant_id'
    ];
}
