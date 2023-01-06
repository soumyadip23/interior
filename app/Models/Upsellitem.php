<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upsellitem extends Model
{
    protected $table = 'upsellitems';

    protected $fillable = [
       'item_id', 'upsell_id'
    ];
}
