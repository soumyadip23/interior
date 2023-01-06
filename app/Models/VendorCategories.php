<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCategories extends Model
{
    protected $table = 'vendor_categories';

	protected $fillable = [
	    'vendor_id', 'cat_id'
	];

}
