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
        'start_at',
        'end_at',
        'language',
        'user_id',
        'order',
        'reference'
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime:Y-m-d',
            'end_at' => 'datetime:Y-m-d',
        ];
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function buttons(): HasMany
    {
        return $this->hasMany(Button::class);
    }
}
