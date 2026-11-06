<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopSupplier extends Model
{
    protected $table = 'shop_suppliers';
    protected $fillable = [
        'supplier_id',
        'user_id',
        'shop_id',
        'name',
        'email',
        'phone',
        'address',
        'tax_id',
        'description',
        'status',
    ];
}
