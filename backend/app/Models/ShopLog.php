<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopLog extends Model
{
    protected $table = 'shop_logs';
    protected $fillable = [
        'log_id',
        'user_id',
        'shop_id',
        'details',
        'status',
    ];
}
