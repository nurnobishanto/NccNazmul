<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'order_id', 'amount', 'payment_method', 'transaction_id', 'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
