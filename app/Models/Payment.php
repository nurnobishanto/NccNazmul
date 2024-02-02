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
    public static function generateUniqueTransactionID($prefix)
    {
        $characters = '0123456789';

        do {
            $transactionID = $prefix;
            for ($i = 0; $i < 6; $i++) {
                $transactionID .= $characters[rand(0, strlen($characters) - 1)];
            }
        } while (self::where('transaction_id', $transactionID)->exists());

        return $transactionID;
    }
}
