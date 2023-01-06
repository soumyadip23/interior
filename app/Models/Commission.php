<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $table = 'commissions';

    protected $fillable = [
       'title', 'min_order', 'max_order', 'value', 'status'
    ];
}
