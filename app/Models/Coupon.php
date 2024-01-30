<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code', 'amount', 'model', 'type', 'maximum', 'expired_at', 'status'
    ];

    protected $dates = [
        'expired_at', 'created_at', 'updated_at', 'deleted_at'
    ];
}
