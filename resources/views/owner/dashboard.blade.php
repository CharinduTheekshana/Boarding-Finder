<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">Owner Dashboard</h2>
                <p class="text-sm text-gray-500">Track listings, approvals, and incoming reviews.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('owner.boardings.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">Add New Listing</a>
                <a href="{{ route('owner.boardings.index') }}" class="rounded-full border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-700">Manage Listings</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8">
            <!-- <section class="rounded-2xl bg-indigo-700 p-6 shadow-sm"> -->
                   <div>
                 <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <!-- <p class="text-xs uppercase tracking-[0.25em] text-indigo-200">Owner space</p>
                        <h3 class="mt-2 text-2xl font-semibold text-white">Keep your listings sharp and approved</h3>
                        <p class="mt-1 text-sm text-indigo-100">Create new ads, track approvals, and respond to student reviews.</p> -->
                    </div>
                </div>
            </section>

            <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-indigo-100 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-indigo-500">Total</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-sm text-gray-500">Listings created</p>
                </div>
                <div class="rounded-2xl border border-indigo-100 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-indigo-500">Approved</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['approved'] }}</p>
                    <p class="text-sm text-gray-500">Live listings</p>
                </div>
                <div class="rounded-2xl border border-indigo-100 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-indigo-500">Pending</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['pending'] }}</p>
                    <p class="text-sm text-gray-500">Awaiting review</p>
                </div>
                <div class="rounded-2xl border border-indigo-100 bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-indigo-500">Reviews</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['reviews'] }}</p>
                    <p class="text-sm text-gray-500">Student ratings</p>
                </div>
            </section>

            <section class="rounded-2xl border border-indigo-100 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Your latest listings</h3>
                        <p class="text-sm text-gray-500">Keep an eye on approval status and quick edits.</p>
                    </div>
                    <a href="{{ route('owner.boardings.index') }}" class="text-sm font-semibold text-indigo-600">View all</a>
                </div>

                <div class="mt-4 overflow-hidden rounded-xl border border-indigo-100">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 text-left font-semibold text-gray-600">Title</th>
                                <th class="p-3 text-left font-semibold text-gray-600">City</th>
                                <th class="p-3 text-left font-semibold text-gray-600">Price</th>
                                <th class="p-3 text-left font-semibold text-gray-600">Status</th>
                                <th class="p-3 text-left font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($boardings as $boarding)
                                <tr class="bg-white">
                                    <td class="p-3 font-medium text-gray-900">{{ $boarding->title }}</td>
                                    <td class="p-3 text-gray-600">{{ $boarding->city }}</td>
                                    <td class="p-3 text-gray-600">Rs {{ number_format($boarding->price) }}</td>
                                    <td class="p-3">
                                        @php($status = str($boarding->approved_status)->lower())
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                            {{ $status === 'approved' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                            {{ $status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                            {{ $status === 'rejected' ? 'bg-rose-100 text-rose-700' : '' }}
                                        ">
                                            {{ str($boarding->approved_status)->title() }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('owner.boardings.edit', $boarding) }}" class="text-sm font-semibold text-indigo-600">Edit</a>
                                            <form method="POST" action="{{ route('owner.boardings.destroy', $boarding) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-sm font-semibold text-rose-600" onclick="return confirm('Delete this listing?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div>{{ $boardings->links() }}</div>
        </div>
    </div>
</x-app-layout>
