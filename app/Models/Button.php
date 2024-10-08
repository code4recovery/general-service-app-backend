<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'title',
        'link',
        'type',
        'event_title',
        'start',
        'end',
        'timezone',
        'formatted_address',
        'conference_url',
        'notes',
        'style',
        'order',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

}
