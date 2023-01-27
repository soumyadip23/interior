<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuatationDetails extends Model
{
    protected $table = 'quatation_details';

    protected $fillable = [
       'quatation_id', 'item_variation_id', 'quantity', 'price', 
    ];
    public function quatation(){
    	return $this->belongsTo(Quatation::class, 'id');
	}
}
