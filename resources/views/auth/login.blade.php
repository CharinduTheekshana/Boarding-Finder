<x-guest-layout>
    <div class="space-y-3">
        <p class="text-xs uppercase tracking-[0.3em] text-indigo-600">Sign in</p>
        <h2 class="text-2xl font-semibold text-gray-900">Welcome back</h2>
        <p class="text-sm text-gray-600">Login to manage favourites and submit reviews.</p>
    </div>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
            <input id="email" class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
            <input id="password" class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-gray-600">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                Remember me
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-indigo-600" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button class="w-full rounded-xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white shadow-sm">Log in</button>

        <p class="text-center text-sm text-gray-600">
            New here?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600">Create an owner account</a>
        </p>
    </form>
</x-guest-layout>
