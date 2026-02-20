<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manage Boarding Ads</h2>
            <a href="{{ route('owner.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">← Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('status') }}</div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('owner.boardings.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-white">Add Boarding Listing</a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($boardings as $boarding)
                    <div>
                        @include('partials.boarding-card', ['boarding' => $boarding])
                        <div class="mt-2 flex items-center justify-between text-sm">
                            <span class="text-gray-600">{{ str($boarding->approved_status)->title() }}</span>
                            <div class="flex gap-3">
                                <a href="{{ route('owner.boardings.edit', $boarding) }}" class="text-indigo-600">Edit</a>
                                <form method="POST" action="{{ route('owner.boardings.destroy', $boarding) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600" onclick="return confirm('Delete this listing?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>{{ $boardings->links() }}</div>
        </div>
    </div>
</x-app-layout>
