<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function setSlugAttribute($value)
    {
        // Agar manually slug diya gaya hai to use karo, warna name se banao
        $slug = $value ?: Str::slug($this->attributes['name']);

        $original = $slug;
        $count = 1;

        // Jab tak unique slug na mil jaye, number add karte raho
        while (static::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        $this->attributes['slug'] = $slug;
    }
}