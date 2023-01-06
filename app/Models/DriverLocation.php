<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    public function driver() {
        return $this->belongsTo('App\Models\DeliveryBoy', 'driver_id', 'id');
    }
}
