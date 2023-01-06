<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    protected $table = 'staffs';

    protected $fillable = [
        'name', 'mobile', 'email', 'password', 'image', 'country', 'city', 'address', 'pin','gender','date_of_birth', 'status', 'is_deleted', 'is_available',
    ];

    //hasOne relation with Vehicle Model
    public function vehicle(){
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_type');
    }
}
