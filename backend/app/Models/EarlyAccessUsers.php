<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarlyAccessUsers extends Model
{
    protected $table = 'early_access_users';
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'store_type',
    ];
}
