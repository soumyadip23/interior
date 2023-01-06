<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryBoyEarning extends Model
{
    protected $table = 'delivery_boy_earnings';

    protected $fillable = [
       'delivery_boy_id', 'type', 'delivery_date', 'no_of_orders', 'amount'
    ];
}
