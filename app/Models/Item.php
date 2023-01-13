<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'category_id', 'name', 'image', 'description',  'status'
    ];

    //hasOne relation with Category Model
    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function itemVariation(){
    	return $this->hasMany(ItemVariation::class);
	}
}
