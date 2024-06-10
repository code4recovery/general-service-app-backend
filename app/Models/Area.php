<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'website',
        'timezone',
    ];

    public function number(): string
    {
        return str_pad($this->id, 2, '0', STR_PAD_LEFT);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

}
