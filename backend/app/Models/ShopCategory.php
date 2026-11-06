<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    protected $table = 'shop_categories';
    protected $fillable = [
        'category_id',
        'user_id',
        'shop_id',
        'name',
        'description',
        'status',
    ];
}
