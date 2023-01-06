<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
       'unique_id', 'restaurant_id', 'user_id', 'delivery_boy_id', 'name', 'email', 'delivery_address', 'delivery_landmark', 'delivery_country', 'delivery_city', 'delivery_pin', 'delivery_lat', 'delivery_lng', 'amount', 'coupon_code', 'discounted_amount', 'delivery_charge', 'packing_price', 'tax_amount', 'total_amount', 'status', 'transaction_id', 'payment_status', 'is_deleted'
    ];

    //hasOne relation with Restaurant Model
    public function restaurant(){
        return $this->hasOne(Restaurant::class, 'id', 'restaurant_id');
    }

    //hasOne relation with DeliveryBoy Model
    public function boy(){
        return $this->hasOne(DeliveryBoy::class, 'id', 'delivery_boy_id');
    }

    //hasMany relation with Orderitem Model
    public function items(){
        return $this->hasMany(Orderitem::class);
    }
} 