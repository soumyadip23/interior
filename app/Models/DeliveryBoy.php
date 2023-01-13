<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DeliveryBoy extends Authenticatable
{
    protected $table = 'staffs';

    protected $fillable = [
        'name', 'mobile', 'email', 'password', 'image', 'country', 'city', 'address', 'pin','gender','date_of_birth', 'status', 'is_deleted', 'is_available',
    ];


}
