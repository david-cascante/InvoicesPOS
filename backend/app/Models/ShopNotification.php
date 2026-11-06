<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopNotification extends Model
{
    protected $table = 'shop_notifications';
    protected $fillable = [
        'notification_id',
        'shop_id',
        'details',
        'status',
    ];
}
