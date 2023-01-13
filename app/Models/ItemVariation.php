<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariation extends Model
{
    protected $table = 'item_variations';

    protected $fillable = [
        'item_id', 'name',  'price', 'unit',  'in_stock'
    ];

    //hasOne relation with Category Model
    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function item(){
    	return $this->belongsTo(ItemVariation::class, 'id');
	}
}
