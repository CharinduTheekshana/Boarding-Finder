<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-700">Boarding Finder</a>

            <div class="flex items-center gap-4 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-700">Home</a>
                <a href="{{ route('ads.index') }}" class="text-gray-700 hover:text-indigo-700">All Ads</a>

                @auth
                    @if (auth()->user()->hasRole('owner'))
                        <a href="{{ route('owner.dashboard') }}" class="rounded-md bg-indigo-600 px-3 py-1.5 text-white">Dashboard</a>
                    @elseif (auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="rounded-md bg-indigo-600 px-3 py-1.5 text-white">Dashboard</a>
                    @elseif (auth()->user()->hasRole('student'))
                        <a href="{{ route('favourites.index') }}" class="rounded-md bg-indigo-600 px-3 py-1.5 text-white">Favourites</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-700">Login</a>
                    <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-3 py-1.5 text-white">Register (Owner)</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
