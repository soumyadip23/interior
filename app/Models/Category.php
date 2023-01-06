<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

	protected $fillable = [
	   'title', 'image', 'status','description','position'
	];

	

    //hasMany relation with Item Model
	public function items(){
	    return $this->hasMany(Item::class);
	}
}
