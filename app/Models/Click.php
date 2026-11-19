<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    protected $fillable = [
        'short_url_id',
        'ip',
        'device',
        'referrer',
        'user_agent',
        'clicked_at',
    ];
}
