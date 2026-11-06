<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    protected $table = 'shop_products';
    protected $fillable = [
        'product_id',
        'user_id',
        'shop_id',
        'category_id',
        'supplier_id',
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'units',
        'unit_measurement',
        'bar_code',
        'image_path',
        'stock_alert',
        'tax',
        'continued',
        'status',
    ];
}
