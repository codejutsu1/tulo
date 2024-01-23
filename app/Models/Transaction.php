<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable =  [
        'user_id',
        'package_id',
        'order_id',
        'status',
        'message',
        'phone',
        'amount',
        'original_price',
        'profit',
        'data_plan',
        'cable_tv',
        'subscription_plan',
        'smartcard_number',
        'description'
    ];
}
