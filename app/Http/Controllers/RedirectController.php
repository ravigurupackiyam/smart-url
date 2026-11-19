<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\ShortUrl;


class RedirectController extends Controller
{
    public function __invoke(Request $request, string $code)
    {

        // $data = Cache::remember("url: {$code}", 3600, function() use ($code) {
        $url = ShortUrl::where('code', $code)->first(['id', 'original_url', 'expires_at']);
        $data =  $url ? [
            'id'      => $url->id,
            'url'     => $url->original_url,
            'expires' => $url->expires_at?->timestamp,
        ] : false;
        // });

        abort_if($data === false, 404);
        dd($code);
    }
}
