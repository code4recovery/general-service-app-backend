<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'area',
        'district',
        'name',
        'banner',
        'website',
        'language',
    ];

    public function name(): string
    {
        if (!$this->area) {
            // gso
            return $this->name;
        }
        if (!$this->district) {
            // area
            return 'Area ' . str_pad($this->area, 2, '0', STR_PAD_LEFT) . ': ' . $this->name;
        }
        // district
        return 'Area ' . str_pad($this->area, 2, '0', STR_PAD_LEFT) . ' - District ' .
            str_pad($this->district, 2, '0', STR_PAD_LEFT) . ': ' . $this->name;
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
