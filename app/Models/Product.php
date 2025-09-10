<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ImageKit\ImageKit;
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
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('default-image.jpg'); // fallback image
        }

        $imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.url_endpoint')
        );

        $fileDetails = $imageKit->getFileDetails($this->image);

        if (isset($fileDetails->result) && isset($fileDetails->result->url)) {
            return explode('?', $fileDetails->result->url)[0];
        }

        return asset('default-image.jpg'); // fallback
    }
}