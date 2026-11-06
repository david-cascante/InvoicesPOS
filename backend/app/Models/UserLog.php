<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_logs';
    protected $fillable = [
        'log_id',
        'user_id',
        'details',
        'status',
    ];
}
