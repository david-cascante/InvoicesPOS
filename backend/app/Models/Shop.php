<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';
    protected $fillable = [
        'shop_id',
        'user_id',
        'license_id',
        'shop_key',
        'api_token',
        'name',
        'type',
        'currency',
        'ip_address',
        'credits',
        'status',
    ];
}
