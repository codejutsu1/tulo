<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable =  [
        'user_id',
        'package_id',
        'reference',
        'order_id',
        'status',
        'message',
        'phone',
        'network',
        'amount',
        'original_price',
        'profit',
        'data_plan',
        'cable_tv',
        'subscription_plan',
        'smartcard_number',
        'description'
    ];

    public function getRouteKeyName()
    {
        return 'identifier';
    }

    public function uniqueIds(): array
    {
        return ['identifier'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // protected static function booted(): void
    // {
    //     static::addGlobalScope('user', function (Builder $builder){
    //         $builder->where('user_id', Auth::id());
    //     });
    // }
}
