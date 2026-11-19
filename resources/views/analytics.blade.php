@extends('layouts.app')
@section('title', 'Analytics')

@section('content')
<a href="{{ route('dashboard') }}" class="text-sm text-blue-600">← Back to dashboard</a>

<div class="mt-3 mb-6">
    <h1 class="text-xl font-semibold font-mono">{{ url($url->code) }}</h1>
    <p class="text-sm text-gray-500 truncate">{{ $url->original_url }}</p>
</div>

<div class="grid gap-4 md:grid-cols-3 mb-8">
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Total clicks</p>
        <p class="text-3xl font-bold">{{ number_format($url->clicks_count) }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Last 30 days</p>
        <p class="text-3xl font-bold">{{ number_format($perDay->sum()) }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Expires</p>
        <p class="text-lg font-semibold">{{ $url->expires_at?->format('d M Y, H:i') ?? 'Never' }}</p>
    </div>
</div>

<div class="grid gap-6 md:grid-cols-3">
    <div class="bg-white rounded-lg shadow p-5 md:col-span-2">
        <h3 class="font-semibold mb-3">Clicks per day (30 days)</h3>
        <canvas id="dailyChart" height="120"></canvas>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <h3 class="font-semibold mb-3">Devices</h3>
        <canvas id="deviceChart"></canvas>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-5 mt-6">
    <h3 class="font-semibold mb-3">Top referrers</h3>
    <table class="w-full text-sm">
        <tbody>
        @forelse ($referrers as $r)
            <tr class="border-t">
                <td class="py-2 truncate max-w-md">{{ $r->referrer }}</td>
                <td class="py-2 text-right">{{ $r->total }}</td>
            </tr>
        @empty
            <tr><td class="py-2 text-gray-500">No referrer data yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('dailyChart'), {
    type: 'line',
    data: {
        labels: @json($perDay->keys()),
        datasets: [{ label: 'Clicks', data: @json($perDay->values()), borderColor: '#2563eb', tension: .3, fill: false }]
    },
    options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
});

new Chart(document.getElementById('deviceChart'), {
    type: 'doughnut',
    data: {
        labels: @json($devices->keys()),
        datasets: [{ data: @json($devices->values()) }]
    }
});
</script>
@endpush
