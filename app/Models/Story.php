<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'title',
        'type',
        'description',
        'effective_at',
        'expire_at',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'effective_at' => 'datetime',
            'expire_at' => 'datetime',
        ];
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function buttons(): HasMany
    {
        return $this->hasMany(Button::class);
    }
}
