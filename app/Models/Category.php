<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
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