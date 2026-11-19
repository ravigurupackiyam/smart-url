<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ShortUrl;
use App\Models\Click;

class RecordClick implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $shortUrlId, public array $meta)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ua = $this->meta['user_agent'] ?? '';
        $device = match (true) {
            (bool) preg_match('/tablet|ipad/i', $ua) => 'tablet',
            (bool) preg_match('/mobile|android|iphone/i', $ua) => 'mobile',
            default => 'desktop',
        };

        Click::create($this->meta + ['short_url_id' => $this->shortUrlId, 'device' => $device]);
        ShortUrl::whereKey($this->shortUrlId)->increment('clicks_count');
    }
}
