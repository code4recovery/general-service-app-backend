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
        'color',
        'boundary',
        'map_id',
        'timezone',
        'order',
        'description',
    ];

    public function name(): string
    {
        if (!$this->area) {
            // gso
            return __($this->name);
        }
        if (!$this->district) {
            // area
            return __(':area: :name', [
                'area' => $this->area(),
                'name' => $this->name
            ]);
        }
        if (!$this->name) {
            // district
            return __('District :district', [
                'district' => $this->district,
                'name' => $this->name
            ]);
        }

        return __('District :district: :name', [
            'district' => $this->district,
            'name' => $this->name
        ]);

    }


    public function area(): string
    {
        return $this->area ? $this->format($this->area) : '';
    }

    private function format($number): string
    {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
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
            return __('District');
        }
        if ($this->area) {
            return __('Area');
        }
        return __('GSO');
    }

}
