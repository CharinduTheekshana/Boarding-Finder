<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Favourite Boardings</h2>
            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">← Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($favourites as $boarding)
                    @include('partials.boarding-card', ['boarding' => $boarding])
                @empty
                    <p class="text-gray-600">No favourites saved yet.</p>
                @endforelse
            </div>
            <div class="mt-6">{{ $favourites->links() }}</div>
        </div>
    </div>
</x-app-layout>
