<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Popular Cities in {{ $district }} - Boarding Finder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">
    @include('partials.public-navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8 flex-1">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Popular Cities in {{ $district }}</h1>
                <p class="mt-2 text-gray-600">Select a city to view all ads in that area.</p>
            </div>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">← Back to Home</a>
        </div>

        @if($cities->isEmpty())
            <div class="rounded-lg bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3">
                <p>No popular cities with active listings found in {{ $district }} district yet.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach ($cities as $city)
                    <a href="{{ route('ads.index', ['city' => $city['name']]) }}" class="rounded-xl overflow-hidden border border-gray-200 bg-white hover:shadow-md transition">
                        <img src="{{ $city['image'] }}" alt="{{ $city['name'] }}" class="h-28 w-full object-cover">
                        <p class="px-3 py-2 text-sm font-medium">{{ $city['name'] }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </main>

    @include('partials.public-footer')
</body>
</html>
