<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable
// {
//     protected $table = 'users';

// 	protected $fillable = [
// 	   'name', 'mobile', 'email', 'otp', 'country', 'city', 'address', 'is_verified', 'status', 'is_deleted'
// 	];

// 	//hasMany relation with Loop Model
// 	public function loops()
// 	{
//     	return $this->hasMany(Loop::class);
// 	}
// }
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password','mobile'
    // ];
     protected $fillable = [
        'name', 'mobile', 'email','image', 'password', 'otp', 'country', 'city', 'address', 'is_verified', 'status', 'is_deleted','device_id','device_token'
     ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    //hasMany relation with Address Model
    public function addresses(){
        return $this->hasMany(Address::class);
    }
}
