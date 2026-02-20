<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manage Reviews & Ratings</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">← Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Student</th>
                            <th class="p-3 text-left">Boarding</th>
                            <th class="p-3 text-left">Ratings</th>
                            <th class="p-3 text-left">Comment</th>
                            <th class="p-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr class="border-t">
                                <td class="p-3">{{ $review->user->name }}</td>
                                <td class="p-3">{{ $review->boarding->title }}</td>
                                <td class="p-3">S: {{ $review->safety }} | C: {{ $review->cleanliness }} | F: {{ $review->facilities }}</td>
                                <td class="p-3">{{ $review->comment }}</td>
                                <td class="p-3">
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>{{ $reviews->links() }}</div>
        </div>
    </div>
</x-app-layout>
