<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart URL')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
</head>

<body>
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="font-bold text-lg">🔗 Smart-URL</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-gray-600 hover:text-red-600">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
