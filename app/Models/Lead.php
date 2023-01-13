<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'leads';

	protected $fillable = [
	   'id','uid','customer_name', 'customer_mobile','customer_email','customer_address', 'customer_lat', 'customer_long','requirement','source','remarks','budget','created_by','assigned_to','status'
	];

	//hasMany relation with Blogtag Model
	// public function tags(){
    // 	return $this->hasMany(Blogtag::class);
	// }

	// //hasOne relation with Blogcategory Model
	// public function category(){
	//     return $this->hasOne(Blogcategory::class, 'id', 'category_id');
	// }
}
