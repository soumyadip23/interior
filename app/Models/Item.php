<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
       'restaurant_id', 'category_id', 'name', 'image', 'description', 'price', 'offer_price', 'is_veg', 'is_cutlery_required', 'min_item_for_cutlery', 'in_stock', 'status'
    ];

    //hasOne relation with Restaurant Model
    public function restaurant(){
        return $this->hasOne(Restaurant::class, 'id', 'restaurant_id');
    }

    //hasOne relation with Category Model
    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
