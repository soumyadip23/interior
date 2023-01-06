<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantReview extends Model
{
    protected $table = 'restaurant_reviews';

    protected $fillable = [
       'restaurant_id', 'user_id', 'order_ref_id', 'rating', 'review'
    ];

    //hasOne relation with Restaurant Model
    public function restaurant(){
        return $this->hasOne(Restaurant::class, 'id', 'restaurant_id');
    }

    //hasOne relation with User Model
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
