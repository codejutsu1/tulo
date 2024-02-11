<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function utility(): BelongsTo
    {
        return $this->belongsTo(Utility::class);
    }
}
