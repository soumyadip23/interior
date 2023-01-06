<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SosNotification extends Model
{
    protected $table = 'sos_notifications';

    protected $fillable = [
       'delivery_boy_id', 'notification'
    ];

    //hasOne relation with DeliveryBoy Model
    public function boy(){
        return $this->hasOne(DeliveryBoy::class, 'id', 'delivery_boy_id');
    }
}
