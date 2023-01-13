<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

	protected $fillable = [
	   'parent_id','title', 'image', 'status','description','position'
	];

	public function childs() {
        return $this->hasMany('App\Models\Category','parent_id','id') ;
    }

    //hasMany relation with Item Model
	public function items(){
	    return $this->hasMany(Item::class);
	}
}
