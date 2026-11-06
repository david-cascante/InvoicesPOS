<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'leads';
    protected $fillable = [
        'lead_id',
        'reason',
        'name',
        'email',
        'message',
        'ip_address',
        'timezone',
        'status',
    ];
}
