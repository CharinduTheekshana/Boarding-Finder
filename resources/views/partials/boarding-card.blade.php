<article class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    <a href="{{ route('ads.show', $boarding) }}">
        <img
            src="{{ $boarding->primary_image_url ?? 'https://placehold.co/600x380?text=Boarding+Image' }}"
            alt="{{ $boarding->title }}"
            class="h-44 w-full object-cover"
        >
    </a>

    <div class="p-4 space-y-2">
        <div class="flex items-start justify-between gap-2">
            <h3 class="font-semibold text-gray-900">{{ $boarding->title }}</h3>
            <p class="text-indigo-700 font-bold">Rs {{ number_format($boarding->price) }}</p>
        </div>

        <p class="text-sm text-gray-600">{{ $boarding->city }} {{ $boarding->district ? '• '.$boarding->district : '' }}</p>
        <p class="text-sm text-gray-600 line-clamp-2">{{ $boarding->description }}</p>
        <p class="text-sm text-amber-600 font-medium">Rating: {{ number_format($boarding->average_rating, 1) }} / 5</p>
    </div>
</article>
