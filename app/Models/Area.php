<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
