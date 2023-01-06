<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

	protected $fillable = [
	   'title', 'category_id','sub_category_id','description', 'image', 'status'
	];

	//hasMany relation with Blogtag Model
	public function tags(){
    	return $this->hasMany(Blogtag::class);
	}

	//hasOne relation with Blogcategory Model
	public function category(){
	    return $this->hasOne(Blogcategory::class, 'id', 'category_id');
	}
}
