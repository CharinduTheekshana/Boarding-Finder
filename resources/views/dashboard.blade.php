<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <!-- <div>
                <h2 class="text-2xl font-semibold text-gray-900">Student Dashboard</h2>
                <p class="text-sm text-gray-500">Find stays, save favourites, and track your reviews.</p>
            </div> -->
            <!-- <div class="flex flex-wrap gap-3">
                <a href="{{ route('ads.index') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">Browse All Ads</a>
                <a href="{{ route('favourites.index') }}" class="rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">My Favourites</a>
            </div> -->
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8">
            <section class="rounded-2xl border border-indigo-100 bg-gradient-to-r from-indigo-50 via-white to-amber-50 p-6 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-indigo-600">Student space</p>
                        <h3 class="mt-2 text-2xl font-semibold text-gray-900">Your next stay starts here</h3>
                        <p class="mt-1 text-sm text-gray-600">Shortlist listings, compare ratings, and keep your reviews in one place.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('ads.index') }}" class="rounded-xl bg-gray-900 px-5 py-2 text-sm font-semibold text-white">Explore Listings</a>
                        <a href="{{ route('favourites.index') }}" class="rounded-xl bg-white px-5 py-2 text-sm font-semibold text-gray-900 ring-1 ring-gray-200">View Favourites</a>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Favourites</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['favourites'] }}</p>
                    <p class="text-sm text-gray-500">Saved listings</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Reviews</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['reviews'] }}</p>
                    <p class="text-sm text-gray-500">Ratings submitted</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">New this week</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['new_ads'] }}</p>
                    <p class="text-sm text-gray-500">Fresh listings</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Avg rating</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($stats['avg_rating'], 1) }}</p>
                    <p class="text-sm text-gray-500">From your reviews</p>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Latest ads</h3>
                        <a href="{{ route('ads.index') }}" class="text-sm font-semibold text-indigo-600">View all</a>
                    </div>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        @forelse ($latestBoardings as $boarding)
                            @include('partials.boarding-card', ['boarding' => $boarding])
                        @empty
                            <p class="text-sm text-gray-600">No listings available right now.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Recent reviews</h3>
                    </div>
                    <div class="mt-4 space-y-4">
                        @forelse ($recentReviews as $review)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $review->boarding->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $review->boarding->city }}</p>
                                    </div>
                                    <span class="text-sm font-semibold text-amber-600">{{ number_format($review->average_rating, 1) }}/5</span>
                                </div>
                                @if ($review->comment)
                                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $review->comment }}</p>
                                @endif
                                <a href="{{ route('ads.show', $review->boarding) }}" class="mt-3 inline-flex text-sm font-semibold text-indigo-600">View listing</a>
                            </div>
                        @empty
                            <p class="text-sm text-gray-600">No reviews yet. Share your experience on a listing.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Saved favourites</h3>
                    <a href="{{ route('favourites.index') }}" class="text-sm font-semibold text-indigo-600">View all</a>
                </div>
                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($recentFavourites as $boarding)
                        @include('partials.boarding-card', ['boarding' => $boarding])
                    @empty
                        <p class="text-sm text-gray-600">No favourites saved yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
