<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id', 'shipping_address_id', 'billing_address_id', 'payment_method',
        'paid_amount', 'due', 'delivery_charge', 'note', 'status','order_id'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_id = static::generateOrderId();
        });
    }

    // Generate a unique sequential order ID with a serial number
    protected static function generateOrderId()
    {
        $lastOrderId = static::max('order_id');
        $lastSerial = intval(substr($lastOrderId, 12));
        $newSerial = $lastSerial + 1;
        $orderId = 'ORD' . date('YmdHis') . str_pad($newSerial, 4, '0', STR_PAD_LEFT);
        return $orderId;
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'billing_address_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
