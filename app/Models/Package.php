<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'utility_id',
        'variation_id',
        'plan',
        'original_price',
        'price',
        'service_id',
        'profit'
    ];
}
