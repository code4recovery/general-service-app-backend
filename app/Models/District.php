<?php

namespace App\Models;

use User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'number',
        'name',
        'website'
    ];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
