<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
       'user_id', 'amount', 'type', 'transaction_id', 'order_id', 'comment'
    ];
}
