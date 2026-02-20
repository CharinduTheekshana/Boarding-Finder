<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Listing Submitted</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 mb-4">{{ session('status') }}</div>
            @endif

            <div class="rounded-xl bg-white p-6 shadow space-y-4">
                <h3 class="text-lg font-semibold">{{ $boarding->title }}</h3>
                <p class="text-gray-600">Your ad is currently in <span class="font-semibold text-amber-600">Pending</span> status.</p>
                <p class="text-sm text-gray-500">An admin will review your listing shortly. You can edit the listing while it is pending.</p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('owner.boardings.edit', $boarding) }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-white">Edit Listing</a>
                    <a href="{{ route('owner.boardings.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-gray-700">Back to My Listings</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
