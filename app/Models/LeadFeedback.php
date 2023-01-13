<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadFeedback extends Model
{
    protected $table = 'lead_feedbacks';

	protected $fillable = [
	   'id','lead_id', 'client_comment','staff_comment','next_follow_date'
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
