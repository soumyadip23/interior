<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    protected $table = 'incentives';

    protected $fillable = [
       'title', 'min_order', 'max_order', 'value', 'status'
    ];
}
