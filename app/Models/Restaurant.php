<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
   protected $table = 'restaurants';

   protected $fillable = [
       'name', 'mobile', 'email', 'password', 'image', 'description', 'address', 'location', 'lat', 'lng', 'start_time', 'close_time', 'is_pure_veg', 'commission_rate', 'estimated_delivery_time', 'is_not_taking_orders', 'status','including_tax','tax_rate','minimum_order_amount','order_preparation_time','show_out_of_stock_products_in_app','logo'
   ];

   //hasMany relation with Item Model
   public function categories(){
      return $this->hasMany(Category::class);
   }

   //hasMany relation with Item Model
   public function items(){
      return $this->hasMany(Item::class);
   }
}
