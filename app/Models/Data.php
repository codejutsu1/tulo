<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $fillable = [
        'network_id',
        'variation_id',
        'plan',
        'price',
    ];

    public function network()
    {
        return $this->belongsTo(Network::class);
    }
}