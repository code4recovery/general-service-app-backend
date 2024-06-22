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
        'banner_dark',
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
            return 'Area ' . $this->area() . ': ' . $this->name;
        }
        // district
        return 'Area ' . $this->area() . ' - District ' .
            $this->district() . ': ' . $this->name;
    }


    public function area(): string
    {
        return $this->area ? $this->format($this->area) : '';
    }

    public function district(): string
    {
        return $this->district ? $this->format($this->district) : '';
    }

    private function format($number): string
    {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function type(): string
    {
        if ($this->area && $this->district) {
            return 'District';
        }
        if ($this->area) {
            return 'Area';
        }
        return 'GSO';
    }

}
