<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopInventory extends Model
{
    protected $table = 'shop_inventory';
    protected $fillable = [
        'inventory_id',
        'user_id',
        'product_id',
        'shop_id',
        'quantity',
        'movement_type',
        'notes',
        'purchase_price',
        'sale_price',
        'reference',
        'status',
    ];
}
