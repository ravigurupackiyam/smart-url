<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'original_url',
        'expires_at',
        'clicks_count',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime'
        ];
    }
}
