@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="font-semibold mb-4">Create short URL</h2>

        <form method="POST" action="{{ url('/urls') }}" class="grid gap-4 md:grid-cols-[1fr_220px_auto]">
            @csrf
            <div>
                <input type="url" name="original_url" value="{{ old('original_url') }}"
                    placeholder="https://example.com/products/mobile/iphone" class="w-full border rounded px-3 py-2" required>
                @error('original_url')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}"
                    class="w-full border rounded px-3 py-2">
                @error('expires_at')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Shorten</button>
        </form>
        <p class="text-xs text-gray-500 mt-2">Expiry date is optional. Leave it empty for a permanent link.</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">Short URL</th>
                    <th class="p-3">Original URL</th>
                    <th class="p-3 text-right">Clicks</th>
                    <th class="p-3">Expires</th>
                    <th class="p-3">Status</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($urls as $u)
                    @php $expired = $u->expires_at && $u->expires_at->isPast(); @endphp
                    <tr class="border-t">
                        <td class="p-3 font-mono">
                            <a href="{{ url($u->code) }}" target="_blank" class="text-blue-600">{{ url($u->code) }}</a>
                            <button type="button" data-copy="{{ url($u->code) }}"
                                class="ml-2 text-xs text-gray-500 hover:text-black">Copy</button>
                        </td>
                        <td class="p-3 max-w-xs truncate" title="{{ $u->original_url }}">{{ $u->original_url }}</td>
                        <td class="p-3 text-right">{{ number_format($u->clicks_count) }}</td>
                        <td class="p-3">{{ $u->expires_at?->format('d M Y, H:i') ?? '—' }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-0.5 rounded text-xs {{ $expired ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $expired ? 'Expired' : 'Active' }}
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <a href="{{ url("/urls/{$u->id}/analytics") }}"
                                class="text-blue-600 hover:underline">Analytics</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">No links yet. Create your first one above.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $urls->links() }}</div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-copy]').forEach(btn => {
            btn.addEventListener('click', async () => {
                // console.log(btn.dataset);
                await navigator.clipboard.writeText(btn.dataset.copy);
                const old = btn.textContent;
                btn.textContent = 'Copied!';
                setTimeout(() => btn.textContent = old, 1200);
            });
        });
    </script>
@endpush
