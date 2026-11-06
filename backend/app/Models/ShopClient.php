<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopClient extends Model
{
    protected $table = 'shop_clients';
    protected $fillable = [
        'client_id',
        'user_id',
        'shop_id',
        'document_type',
        'identification',
        'name',
        'email',
        'phone',
        'address',
        'credits',
        'status',
    ];
}
