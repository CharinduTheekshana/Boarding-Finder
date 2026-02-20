<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="text-gray-900 antialiased" style="font-family: 'Space Grotesk', ui-sans-serif, system-ui;">
        <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-amber-50">
            <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-indigo-200/50 blur-3xl"></div>
            <div class="pointer-events-none absolute bottom-0 right-0 h-80 w-80 rounded-full bg-amber-200/40 blur-3xl"></div>

            <div class="relative mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-10 lg:flex-row lg:items-center lg:gap-10">
                <div class="flex-1">
                    <a href="/" class="inline-flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                            <x-application-logo class="h-7 w-7 fill-current text-gray-900" />
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.35em] text-indigo-600">Boarding</p>
                            <p class="text-lg font-semibold text-gray-900">Stay smarter</p>
                        </div>
                    </a>

                    <div class="mt-10 max-w-md space-y-4">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-gray-500">Welcome</p>
                        <h1 class="text-4xl font-semibold text-gray-900">Discover trusted boarding stays with real student reviews.</h1>
                        <p class="text-base text-gray-600">Filter listings, save favourites, and keep your choices organized with a clean student dashboard.</p>
                    </div>

                    <div class="mt-8 grid gap-3 text-sm text-gray-600 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/70 bg-white/70 p-4 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Verified ads</p>
                            <p class="mt-2 text-base font-semibold text-gray-900">Admin reviewed</p>
                        </div>
                        <div class="rounded-2xl border border-white/70 bg-white/70 p-4 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Smart picks</p>
                            <p class="mt-2 text-base font-semibold text-gray-900">Compare ratings</p>
                        </div>
                    </div>
                </div>

                <div class="w-full max-w-lg lg:ml-auto">
                    <div class="rounded-3xl border border-white/70 bg-white/90 p-8 shadow-xl backdrop-blur">
                        <div class="mb-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <span class="text-lg">←</span>
                                Back to home
                            </a>
                        </div>
                        {{ $slot }}
                    </div>
                </div>
            </div>

            <div class="relative mt-10">
                @include('partials.public-footer')
            </div>
        </div>
    </body>
</html>
