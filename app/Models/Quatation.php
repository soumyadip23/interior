<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quatation extends Model
{
    protected $table = 'quatations';

    protected $fillable = [
       'lead_id', 'created_by', 'form_date', 'expiry_date', 'notes', 'status','tax','discount','labour_cost','total','pdf_document'
    ];
    public function quatationDetails(){
    	return $this->hasMany(QuatationDetails::class);
	}
}
