<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $table = 'suggestions';

    protected $fillable = [
       'user_id', 'type', 'name'
    ];
}
