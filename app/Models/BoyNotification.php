<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoyNotification extends Model
{
    protected $table = 'boy_notifications';

	protected $fillable = [
	   'delivery_boy_id', 'type','title','notification'
	];
}