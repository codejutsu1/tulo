<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, HasUuids;

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

    public function uniqueIds(): array
    {
        return ['identifier'];
    }
}
