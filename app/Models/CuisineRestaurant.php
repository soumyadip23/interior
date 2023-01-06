<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuisineRestaurant extends Model
{
    protected $table = 'cuisine_restaurants';

    protected $fillable = [
       'cuisine_id', 'restaurant_id'
    ];
}
