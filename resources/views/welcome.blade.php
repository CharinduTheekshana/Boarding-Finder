<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boarding Finder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="bg-gray-50 text-gray-900"
    x-data="{
        scrollDistricts(direction) {
            const container = this.$refs.districtsTrack;
            if (!container) return;
            const column = container.querySelector('[data-district-column]');
            const step = column ? column.offsetWidth + 16 : 200;
            container.scrollBy({ left: direction * step, behavior: 'smooth' });
        }
    }"
    @keydown.window.left.prevent="scrollDistricts(-1)"
    @keydown.window.right.prevent="scrollDistricts(1)"
>
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
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-2xl font-semibold">Browse by District</h2>
                <p class="text-sm text-gray-500">Use ← → keys or arrows</p>
            </div>

            <div class="relative">
                <button
                    @click="scrollDistricts(-1)"
                    class="absolute left-0 top-1/2 z-10 -translate-y-1/2 rounded-full bg-indigo-600 p-2 text-white shadow hover:bg-indigo-700"
                    title="Previous (←)"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <div
                    x-ref="districtsTrack"
                    class="mx-10 overflow-x-auto scroll-smooth [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                >
                    <div class="flex gap-4 pb-1">
                        @foreach (array_chunk($districts, 2) as $districtColumn)
                            <div data-district-column class="w-40 shrink-0 space-y-4 sm:w-44">
                                @foreach ($districtColumn as $district)
                                    <a href="{{ route('districts.cities', ['district' => $district['name']]) }}" class="block overflow-hidden rounded-xl border border-gray-200 bg-white transition hover:shadow-md">
                                        <img src="{{ $district['image'] }}" alt="{{ $district['name'] }}" class="h-24 w-full object-cover" loading="lazy" onerror="this.onerror=null;this.src='{{ 'https://picsum.photos/seed/'.rawurlencode($district['name']).'/600/400' }}';">
                                        <p class="px-3 py-2 text-sm font-medium">{{ $district['name'] }}</p>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <button
                    @click="scrollDistricts(1)"
                    class="absolute right-0 top-1/2 z-10 -translate-y-1/2 rounded-full bg-indigo-600 p-2 text-white shadow hover:bg-indigo-700"
                    title="Next (→)"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
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
