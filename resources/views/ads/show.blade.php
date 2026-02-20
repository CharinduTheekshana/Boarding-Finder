<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $boarding->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900" x-data="{
    showImage: false,
    currentIndex: 0,
    images: [
        @foreach ($boarding->images as $image)
            '{{ $image->image_url }}',
        @endforeach
    ],
    get currentImage() {
        return this.images[this.currentIndex] || '';
    },
    openImage(index) {
        this.currentIndex = index;
        this.showImage = true;
    },
    nextImage() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
    },
    prevImage() {
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
    }
}" @keydown.window.left="showImage && prevImage()" @keydown.window.right="showImage && nextImage()" @keydown.window.escape="showImage = false">
    @include('partials.public-navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <div class="mb-4 flex items-center justify-end">
            <a href="{{ route('ads.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">← Back to Listings</a>
        </div>

        @if (session('status'))
            <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">
                <p>{{ session('status') }}</p>
                @auth
                    @if (auth()->user()->hasRole('student'))
                        <p class="text-sm mt-2">You can logout using the menu in the top right.</p>
                    @endif
                @endauth
            </div>
        @endif

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                <h1 class="text-3xl font-bold">{{ $boarding->title }}</h1>
                <p class="text-gray-600">{{ $boarding->address }}, {{ $boarding->city }} {{ $boarding->district }}</p>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @forelse ($boarding->images as $index => $image)
                        <img 
                            src="{{ $image->image_url }}" 
                            alt="{{ $boarding->title }}" 
                            class="h-44 w-full object-cover rounded-xl cursor-pointer hover:opacity-90 transition"
                            @click="openImage({{ $index }})"
                        >
                    @empty
                        <img src="https://placehold.co/800x500?text=Boarding+Image" alt="{{ $boarding->title }}" class="h-60 w-full object-cover rounded-xl col-span-full">
                    @endforelse
                </div>

                <div class="rounded-xl bg-white border border-gray-200 p-5">
                    <h2 class="text-xl font-semibold mb-3">Description</h2>
                    <p class="text-gray-700 leading-7">{{ $boarding->description }}</p>
                </div>

                <div class="rounded-xl bg-white border border-gray-200 p-5">
                    <h2 class="text-xl font-semibold mb-3">Google Map</h2>
                    @if ($boarding->latitude && $boarding->longitude)
                        <div id="map" class="h-72 rounded-lg" data-lat="{{ $boarding->latitude }}" data-lng="{{ $boarding->longitude }}"></div>
                        @if ($distanceFromUniversity)
                            <p class="mt-3 text-sm text-gray-700">Distance from university: <span class="font-semibold">{{ number_format($distanceFromUniversity, 2) }} km</span></p>
                        @endif
                    @else
                        <p class="text-gray-600">Owner has not provided location coordinates yet.</p>
                    @endif
                </div>
            </div>

            <aside class="space-y-4">
                <div class="rounded-xl bg-white border border-gray-200 p-5 space-y-2">
                    <p class="text-2xl font-bold text-indigo-700">Rs {{ number_format($boarding->price) }}</p>
                    <p class="text-sm">Payment: {{ str($boarding->payment_duration)->title() }}</p>
                    <p class="text-sm">Listed for: {{ str($boarding->listed_for)->title() }}</p>
                    <p class="text-sm">Type: {{ str($boarding->boarding_type)->replace('_', ' ')->title() }}</p>
                    <p class="text-sm">Furnishing: {{ str($boarding->furnishing_status)->replace('_', ' ')->title() }}</p>
                    <p class="text-sm">Average rating: {{ number_format($boarding->average_rating, 1) }}/5</p>
                </div>

                <div class="rounded-xl bg-white border border-gray-200 p-5 space-y-2">
                    <h3 class="font-semibold">Facilities</h3>
                    <p class="text-sm">Bedrooms: {{ $boarding->bedrooms }}</p>
                    <p class="text-sm">Beds: {{ $boarding->beds }}</p>
                    <p class="text-sm">Bathrooms: {{ $boarding->bathrooms }}</p>
                    <p class="text-sm">Kitchen: {{ $boarding->kitchen ? 'Yes' : 'No' }}</p>
                    <p class="text-sm">WiFi: {{ $boarding->wifi ? 'Yes' : 'No' }}</p>
                    <p class="text-sm">Parking: {{ $boarding->parking ? 'Yes' : 'No' }}</p>
                </div>

                @auth
                    @if (auth()->user()->hasRole('student'))
                        @php
                            $hasFavourite = auth()->user()->favouriteBoardings()->where('boarding_id', $boarding->id)->exists();
                        @endphp
                        @if ($hasFavourite)
                            <form method="POST" action="{{ route('favourites.destroy', $boarding) }}">
                                @csrf
                                @method('DELETE')
                                <button class="w-full rounded-lg border border-red-300 bg-red-50 px-4 py-2 text-red-700">Remove Favourite</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('favourites.store', $boarding) }}">
                                @csrf
                                <button class="w-full rounded-lg bg-pink-600 px-4 py-2 text-white">Save to Favourites</button>
                            </form>
                        @endif
                    @endif
                @endauth
            </aside>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-xl bg-white border border-gray-200 p-5">
                <h2 class="text-xl font-semibold mb-3">Ratings Breakdown</h2>
                <p class="text-sm">Safety: {{ number_format($ratingBreakdown['safety'], 1) }}/5</p>
                <p class="text-sm">Cleanliness: {{ number_format($ratingBreakdown['cleanliness'], 1) }}/5</p>
                <p class="text-sm">Facilities: {{ number_format($ratingBreakdown['facilities'], 1) }}/5</p>

                <h3 class="font-semibold mt-5 mb-2">Student Reviews</h3>
                <div class="space-y-3 max-h-60 overflow-y-auto">
                    @forelse ($boarding->reviews as $review)
                        <article class="rounded-lg border border-gray-200 p-3">
                            <p class="text-sm font-medium">{{ $review->user->name }} • {{ number_format($review->average_rating, 1) }}/5</p>
                            <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                        </article>
                    @empty
                        <p class="text-sm text-gray-600">No reviews yet.</p>
                    @endforelse
                </div>
            </div>

            @auth
                @if (auth()->user()->hasRole('student'))
                    <form method="POST" action="{{ route('reviews.store', $boarding) }}" class="rounded-xl bg-white border border-gray-200 p-5 space-y-5">
                        @csrf
                        <h2 class="text-xl font-semibold">Add Your Review</h2>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Safety</p>
                            <div class="mt-2 flex flex-row-reverse justify-end gap-1">
                                @for ($rating = 5; $rating >= 1; $rating--)
                                    <input type="radio" id="safety-{{ $rating }}" name="safety" value="{{ $rating }}" class="peer sr-only" required>
                                    <label for="safety-{{ $rating }}" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-amber-500">★</label>
                                @endfor
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Cleanliness</p>
                            <div class="mt-2 flex flex-row-reverse justify-end gap-1">
                                @for ($rating = 5; $rating >= 1; $rating--)
                                    <input type="radio" id="cleanliness-{{ $rating }}" name="cleanliness" value="{{ $rating }}" class="peer sr-only" required>
                                    <label for="cleanliness-{{ $rating }}" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-amber-500">★</label>
                                @endfor
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Facilities</p>
                            <div class="mt-2 flex flex-row-reverse justify-end gap-1">
                                @for ($rating = 5; $rating >= 1; $rating--)
                                    <input type="radio" id="facilities-{{ $rating }}" name="facilities" value="{{ $rating }}" class="peer sr-only" required>
                                    <label for="facilities-{{ $rating }}" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-amber-500">★</label>
                                @endfor
                            </div>
                        </div>

                        <label class="block text-sm">Comment<textarea name="comment" rows="4" class="mt-1 w-full rounded-lg border-gray-300" placeholder="Share your experience"></textarea></label>
                        <button class="rounded-lg bg-indigo-600 px-5 py-2 text-white">Submit Review</button>
                    </form>
                @else
                    <div class="rounded-xl bg-white border border-gray-200 p-5 space-y-2">
                        <h2 class="text-xl font-semibold">Add Your Review</h2>
                        <p class="text-gray-600">Only students can submit reviews. Please switch to a student account.</p>
                    </div>
                @endif
            @else
                <div class="rounded-xl bg-white border border-gray-200 p-5 space-y-4">
                    <div>
                        <h2 class="text-xl font-semibold">Add Your Review</h2>
                        <p class="text-gray-600">Sign in to continue. Reviews are available for student accounts.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-3">
                        @csrf
                        <input type="hidden" name="intended" value="{{ request()->fullUrl() }}">
                        <input type="hidden" name="intended_role" value="student">
                        <label class="block text-sm">Email<input type="email" name="email" class="mt-1 w-full rounded-lg border-gray-300" required></label>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <label class="block text-sm">Password<input type="password" name="password" class="mt-1 w-full rounded-lg border-gray-300" required></label>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <div class="flex flex-wrap items-center gap-3">
                            <button class="rounded-lg bg-indigo-600 px-5 py-2 text-white">Login to Review</button>
                            <a href="{{ route('register', ['role' => 'student', 'intended' => request()->fullUrl()]) }}" class="text-sm font-semibold text-indigo-600">Register (Student)</a>
                        </div>
                    </form>

                    <p class="text-xs text-gray-500">Login works for owners too. Student accounts are required for reviews.</p>
                </div>
            @endauth
        </section>

        <section>
            <h2 class="text-2xl font-semibold mb-4">Related in {{ $boarding->city }}</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($relatedBoardings as $relatedBoarding)
                    @include('partials.boarding-card', ['boarding' => $relatedBoarding])
                @endforeach
            </div>
        </section>
    </main>

    @include('partials.public-footer')

    <!-- Image Lightbox Modal -->
    <div 
        x-show="showImage" 
        x-cloak
        @click="showImage = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 p-4"
    >
        <div class="relative max-w-3xl w-full" @click.stop>
            <!-- Close Button -->
            <button 
                @click="showImage = false"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 text-4xl font-bold z-10"
                title="Close (Esc)"
            >
                &times;
            </button>

            <!-- Image Counter -->
            <div class="absolute -top-12 left-0 text-white text-sm" x-show="images.length > 0">
                <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
            </div>

            <!-- Previous Button -->
            <button 
                @click="prevImage()"
                x-show="images.length > 1"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white rounded-full p-3 transition"
                title="Previous (←)"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Next Button -->
            <button 
                @click="nextImage()"
                x-show="images.length > 1"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white rounded-full p-3 transition"
                title="Next (→)"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Image -->
            <img :src="currentImage" alt="Boarding Image" class="w-full h-auto rounded-lg shadow-2xl">
        </div>
    </div>

    @if ($boarding->latitude && $boarding->longitude && config('services.google_maps.key'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}"></script>
        <script>
            const mapElement = document.getElementById('map');
            const locationPoint = {
                lat: Number(mapElement.dataset.lat),
                lng: Number(mapElement.dataset.lng),
            };
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: locationPoint,
            });
            new google.maps.Marker({ position: locationPoint, map: map });
        </script>
    @endif
</body>
</html>
