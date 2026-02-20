<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Add Boarding Listing</h2>
            <a href="{{ route('owner.boardings.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">← Back to Listings</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 mb-4">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('owner.boardings.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow space-y-5">
                @csrf
                @include('owner.boardings.form')
                <button class="rounded-lg bg-indigo-600 px-5 py-2 text-white">Submit</button>
            </form>
        </div>
    </div>
</x-app-layout>
