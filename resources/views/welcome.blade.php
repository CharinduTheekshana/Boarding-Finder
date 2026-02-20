<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boarding Finder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    @include('partials.public-navbar')

    <main>
        <section class="bg-indigo-700 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold mb-4">Find the Right Boarding House Faster</h1>
                <p class="text-indigo-100 mb-8">Search by city or district and compare trusted listings.</p>

                <form action="{{ route('ads.index') }}" method="GET" class="bg-white rounded-xl p-3 flex gap-2 max-w-3xl">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search by District or City"
                        class="w-full rounded-lg border-gray-300 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    <button class="rounded-lg bg-indigo-600 px-6 py-2 font-semibold text-white">Search</button>
                </form>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl font-semibold mb-5">Popular Cities</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach ($popularCities as $city)
                    <a href="{{ route('ads.index', ['city' => $city['name']]) }}" class="rounded-xl overflow-hidden border border-gray-200 bg-white hover:shadow-md transition">
                        <img src="{{ $city['image'] }}" alt="{{ $city['name'] }}" class="h-40 w-full object-cover">
                        <p class="px-3 py-2 text-sm font-medium">{{ $city['name'] }}</p>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-semibold">You May Try These Near You</h2>
                <p class="text-sm text-gray-500">Sorted by price low to high</p>
            </div>

            <div class="flex gap-4 overflow-x-auto pb-2 snap-x">
                @foreach ($nearYouBoardings as $boarding)
                    <div class="min-w-[290px] max-w-[290px] snap-start">
                        @include('partials.boarding-card', ['boarding' => $boarding])
                    </div>
                @endforeach
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl font-semibold mb-5">Latest Discoveries</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($latestBoardings as $boarding)
                    @include('partials.boarding-card', ['boarding' => $boarding])
                @empty
                    <p class="text-gray-600">No listings available yet.</p>
                @endforelse
            </div>
        </section>
    </main>

    @include('partials.public-footer')
</body>
</html>
