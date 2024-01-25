<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function utilities()
    {
        return $this->hasMany(Utility::class);
    }

    public function packages()
    {
        return $this->hasManyThrough(Package::class, Utility::class);
    }
}
