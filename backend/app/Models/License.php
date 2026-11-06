<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = 'licenses';
    protected $fillable = [
        'license_id',
        'user_id',
        'license_key',
        'shop_key',
        'plan',
        'duration',
        'transaction_paypal_id',
        'start_date',
        'end_date',
        'status',
        'ip_address',
    ];
}
