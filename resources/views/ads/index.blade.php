<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Boarding Ads</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    @include('partials.public-navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-6">All Ads</h1>

        <form method="GET" action="{{ route('ads.index') }}" class="grid gap-3 md:grid-cols-4 lg:grid-cols-8 bg-white p-4 rounded-xl border border-gray-200 mb-8">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search city or district" class="lg:col-span-2 rounded-lg border-gray-300">

            <select name="city" class="rounded-lg border-gray-300">
                <option value="">City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city }}" @selected(($filters['city'] ?? '') === $city)>{{ $city }}</option>
                @endforeach
            </select>

            <select name="district" class="rounded-lg border-gray-300">
                <option value="">District</option>
                @foreach ($districts as $district)
                    <option value="{{ $district }}" @selected(($filters['district'] ?? '') === $district)>{{ $district }}</option>
                @endforeach
            </select>

            <input type="number" name="price_min" value="{{ $filters['price_min'] ?? '' }}" placeholder="Min price" class="rounded-lg border-gray-300">
            <input type="number" name="price_max" value="{{ $filters['price_max'] ?? '' }}" placeholder="Max price" class="rounded-lg border-gray-300">

            <select name="boarding_type" class="rounded-lg border-gray-300">
                <option value="">Boarding type</option>
                @foreach (['annex','apartment','bungalow','business_space','co_working_space','double_room','full_house','guest_house','home_stay','hostel','house','shared_room','single_room'] as $type)
                    <option value="{{ $type }}" @selected(($filters['boarding_type'] ?? '') === $type)>{{ str($type)->replace('_', ' ')->title() }}</option>
                @endforeach
            </select>

            <select name="listed_for" class="rounded-lg border-gray-300">
                <option value="">Gender allowed</option>
                @foreach (['boys', 'girls', 'both', 'couple', 'family'] as $listed)
                    <option value="{{ $listed }}" @selected(($filters['listed_for'] ?? '') === $listed)>{{ str($listed)->title() }}</option>
                @endforeach
            </select>

            <select name="furnishing_status" class="rounded-lg border-gray-300">
                <option value="">Furnished status</option>
                <option value="furnished" @selected(($filters['furnishing_status'] ?? '') === 'furnished')>Furnished</option>
                <option value="not_furnished" @selected(($filters['furnishing_status'] ?? '') === 'not_furnished')>Not Furnished</option>
            </select>

            <button class="rounded-lg bg-indigo-600 text-white px-4 py-2">Apply Filters</button>
        </form>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($boardings as $boarding)
                @include('partials.boarding-card', ['boarding' => $boarding])
            @empty
                <p class="text-gray-600">No boarding ads found for selected filters.</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $boardings->links() }}</div>
    </main>

    @include('partials.public-footer')
</body>
</html>
