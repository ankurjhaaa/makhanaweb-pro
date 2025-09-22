<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'order_number',
        'subtotal',
        'discount',
        'shipping_cost',
        'total_amount',
        'status',
        'shipping_address_id',
        'billing_address_id',
        'payment_method', // Added to support payment method storage
        'payment_id',
        'notes',         // Added to support order notes
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class)->with('product');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}