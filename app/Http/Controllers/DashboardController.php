<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Services\UrlShortener;
use App\Models\ShortUrl;
class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $urls = Auth::user()->shortUrls()->latest()->paginate(15);
        return view('dashboard', compact('urls'));
    }

    public function store(Request $request, UrlShortener $shortener)
    {
        $data = $request->validate([
            'original_url' => ['required', 'url', 'max:2048'],
            'expires_at'   => ['nullable', 'date', 'after:now'],
        ]);

        $shortener->create(
            $request->user()->id,
            $data['original_url'],
            isset($data['expires_at']) ? Carbon::parse($data['expires_at']) : null,
        );

        return back()->with('success', 'Short URL created!');
    }

    public function analytics(ShortUrl $url)
    {

        $perDay = $url->clicks()
            ->selectRaw('DATE(clicked_at) as day, COUNT(*) as total')
            ->where('clicked_at', '>=', now()->subDays(30))
            ->groupBy('day')->orderBy('day')->pluck('total', 'day');

        $devices = $url->clicks()
            ->selectRaw('device, COUNT(*) as total')
            ->groupBy('device')->pluck('total', 'device');

        $referrers = $url->clicks()
            ->selectRaw('referrer, COUNT(*) as total')
            ->whereNotNull('referrer')
            ->groupBy('referrer')->orderByDesc('total')->limit(10)->get();

        return view('analytics', compact('url', 'perDay', 'devices', 'referrers'));
    }
}
