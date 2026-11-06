<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_log';
    protected $fillable = [
        'system_id',
        'user_id',
        'shop_id',
        'error',
        'method',
        'endpoint',
        'status',
    ];
}
