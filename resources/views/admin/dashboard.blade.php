<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg bg-white p-4 shadow">Total Users (Owners): <strong>{{ $stats['total_users'] }}</strong></div>
                <div class="rounded-lg bg-white p-4 shadow">Total Listings: <strong>{{ $stats['total_listings'] }}</strong></div>
                <div class="rounded-lg bg-white p-4 shadow">Total Reviews: <strong>{{ $stats['total_reviews'] }}</strong></div>
                <div class="rounded-lg bg-white p-4 shadow">Pending Ads: <strong>{{ $stats['pending_ads'] }}</strong></div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.boardings.index') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-white">Manage Listings</a>
                <a href="{{ route('admin.reviews.index') }}" class="rounded-lg bg-gray-800 px-4 py-2 text-white">Manage Reviews</a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Owner Name</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Listings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($owners as $owner)
                            <tr class="border-t">
                                <td class="p-3">{{ $owner->name }}</td>
                                <td class="p-3">{{ $owner->email }}</td>
                                <td class="p-3">{{ $owner->boardings_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>{{ $owners->links() }}</div>

            @if ($pendingBoardings->isNotEmpty())
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-3 border-b text-sm font-semibold">Latest Pending Listings</div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">Title</th>
                                <th class="p-3 text-left">Owner</th>
                                <th class="p-3 text-left">City</th>
                                <th class="p-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingBoardings as $boarding)
                                <tr class="border-t">
                                    <td class="p-3">{{ $boarding->title }}</td>
                                    <td class="p-3">{{ $boarding->owner->name }}</td>
                                    <td class="p-3">{{ $boarding->city }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('admin.boardings.index', ['status' => 'pending']) }}" class="text-indigo-600">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
