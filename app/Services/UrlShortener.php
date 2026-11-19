<?php

namespace App\Services;
use App\Models\ShortUrl;
use Illuminate\Support\Carbon;

class UrlShortener
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CodeGenerator $codes) {}

    public function create(int $userId, string $url, ?Carbon $expiresAt = null): ShortUrl
    {
        return ShortUrl::create([
            'user_id'      => $userId,
            'code'         => $this->codes->generate(),
            'original_url' => $url,
            'expires_at'   => $expiresAt,
        ]);
    }
}
