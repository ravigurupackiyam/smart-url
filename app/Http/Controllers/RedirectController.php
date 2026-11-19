<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\ShortUrl;
use App\Jobs\RecordClick;
use Illuminate\Support\Str;

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
        if ($data['expires'] && $data['expires'] < now()->timestamp) {
            Cache::forget("url:{$code}");
            abort(410, 'This link has expired.');
        }

        // track after the response is sent, so the redirect stays fast
        RecordClick::dispatch($data['id'], [
            'ip'         => $request->ip(),
            'user_agent' => Str::limit($request->userAgent(), 250, ''),
            'referrer'   => Str::limit($request->headers->get('referer'), 250, ''),
        ])->afterResponse();

        return redirect()->away($data['url'], 302);   // 302 so clicks keep reaching you
    }
}
