<x-guest-layout>
    @php
        $isStudent = request('role') === 'student';
    @endphp

    <div class="space-y-3">
        <p class="text-xs uppercase tracking-[0.3em] text-indigo-600">{{ $isStudent ? 'Student sign up' : 'Owner sign up' }}</p>
        <h2 class="text-2xl font-semibold text-gray-900">{{ $isStudent ? 'Create your student profile' : 'Create your owner profile' }}</h2>
        <p class="text-sm text-gray-600">
            {{ $isStudent ? 'Student accounts can submit ratings and reviews.' : 'Registration is available for property owners only.' }}
        </p>
    </div>

    <div class="mt-6 rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] text-indigo-700">
        {{ $isStudent ? 'Student registration' : 'Owner-only registration' }}
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
        @csrf
        <input type="hidden" name="role" value="{{ $isStudent ? 'student' : 'owner' }}">
        @if (request('intended'))
            <input type="hidden" name="intended" value="{{ request('intended') }}">
        @endif

        <div>
            <label for="name" class="text-sm font-medium text-gray-700">Name</label>
            <input id="name" class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Owner name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
            <input id="email" class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="owner@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
            <input id="password" class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" placeholder="Create a secure password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm password</label>
            <input id="password_confirmation" class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button class="w-full rounded-xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white shadow-sm">Create account</button>

        <p class="text-center text-sm text-gray-600">
            Already registered?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600">Back to login</a>
        </p>
    </form>
</x-guest-layout>
