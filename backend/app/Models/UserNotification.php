<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';
    protected $fillable = [
        'notification_id',
        'user_id',
        'details',
        'status',
    ];
}
