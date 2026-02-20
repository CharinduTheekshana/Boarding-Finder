<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Moderate Boarding Listings</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">← Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('status') }}</div>
            @endif

            <form method="GET" class="bg-white p-4 rounded-lg border border-gray-200 flex items-center gap-3 max-w-sm">
                <select name="status" class="rounded-lg border-gray-300">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'approved', 'rejected'] as $item)
                        <option value="{{ $item }}" @selected($status === $item)>{{ str($item)->title() }}</option>
                    @endforeach
                </select>
                <button class="rounded-lg bg-indigo-600 px-3 py-2 text-white">Filter</button>
            </form>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Title</th>
                            <th class="p-3 text-left">Owner</th>
                            <th class="p-3 text-left">City</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($boardings as $boarding)
                            <tr class="border-t">
                                <td class="p-3">{{ $boarding->title }}</td>
                                <td class="p-3">{{ $boarding->owner->name }}</td>
                                <td class="p-3">{{ $boarding->city }}</td>
                                <td class="p-3">{{ str($boarding->approved_status)->title() }}</td>
                                <td class="p-3 flex gap-2">
                                    <form method="POST" action="{{ route('admin.boardings.approve', $boarding) }}">
                                        @csrf @method('PATCH')
                                        <button class="text-green-600">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.boardings.reject', $boarding) }}">
                                        @csrf @method('PATCH')
                                        <button class="text-red-600">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>{{ $boardings->links() }}</div>
        </div>
    </div>
</x-app-layout>
