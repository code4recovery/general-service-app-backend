<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsTo;
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
        'start',
        'end',
        'timezone',
        'formatted_address',
        'conference_url',
        'style',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

}
