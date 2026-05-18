<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EXPORTANI') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|fraunces:600,700&display=swap" rel="stylesheet" />

        @php
            $hasViteAssets = file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'));
        @endphp
        @if ($hasViteAssets)
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['DM Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                                display: ['Fraunces', 'Georgia', 'serif'],
                            },
                        },
                    },
                };
            </script>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @endif
    </head>
    <body class="font-sans text-stone-800 antialiased min-h-screen bg-stone-100">
        <div class="min-h-screen flex flex-col lg:flex-row">
            <aside class="relative lg:w-[42%] xl:w-[40%] min-h-[220px] lg:min-h-screen overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-950 text-emerald-50">
                <div class="absolute inset-0 opacity-[0.07]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
                <div class="relative z-10 flex flex-col justify-between h-full p-8 lg:p-12 xl:p-14 min-h-[220px] lg:min-h-screen">
                    <div>
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                            <x-application-logo class="h-11 w-11 shrink-0 text-white drop-shadow-sm" />
                            <div>
                                <span class="font-display text-xl sm:text-2xl font-semibold tracking-tight text-white leading-tight block">EXPORTANI</span>
                                <span class="text-xs sm:text-sm text-emerald-200/90 font-medium">Petani · Produk · Kerja sama</span>
                            </div>
                        </a>
                    </div>
                    <div class="hidden lg:block space-y-4 max-w-md">
                        <p class="font-display text-2xl xl:text-3xl font-semibold text-white leading-snug">
                            Hubungkan hasil tani langsung ke jaringan ekspor.
                        </p>
                        <p class="text-emerald-100/85 text-sm leading-relaxed">
                            Daftar produk, cari mitra, dan kelola permintaan kerja sama dalam satu alur sederhana.
                        </p>
                    </div>
                    <p class="text-emerald-200/60 text-xs hidden lg:block">MVP — alur inti kemitraan</p>
                </div>
            </aside>

            <main class="flex-1 flex flex-col justify-center px-4 py-10 sm:px-8 lg:px-12 xl:px-16">
                <div class="w-full max-w-md mx-auto lg:mx-0 lg:ml-auto">
                    <div class="rounded-2xl border border-stone-200/80 bg-white/90 shadow-xl shadow-stone-900/5 backdrop-blur-sm p-8 sm:p-9">
                        {{ $slot }}
                    </div>
                    <p class="mt-6 text-center lg:text-left text-xs text-stone-500">
                        &copy; {{ date('Y') }} {{ config('app.name', 'EXPORTANI') }}
                    </p>
                </div>
            </main>
        </div>
    </body>
</html>
