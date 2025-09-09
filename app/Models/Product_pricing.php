<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_pricing extends Model
{
    protected $fillable = ['product_id', 'combo_products', 'quantity', 'price'];
}
