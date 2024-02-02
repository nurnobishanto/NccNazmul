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
            $order->order_id = static::generateUniqueOrderId();
        });
    }

    // Generate a unique sequential order ID with a serial number
    protected static function generateOrderId()
    {
        return static::max('id') + 1;
    }
    public static function generateUniqueOrderId()
    {
        $currentYear = now()->year % 100;
        $currentMonth = now()->month;
        // Format the user ID with a prefix (e.g., 231100001)
        return sprintf('%02d%02d%04d', $currentYear, $currentMonth, self::generateOrderId());
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
