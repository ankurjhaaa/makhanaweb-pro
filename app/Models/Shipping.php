<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['method_name', 'cost', 'estimated_delivery_days', 'status'];
}