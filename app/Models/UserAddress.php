<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';

    protected $fillable = [
       'user_id', 'address', 'location', 'lat', 'lng', 'country', 'state', 'city', 'pin', 'tag'
    ];

    //hasOne relation with User Model
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
