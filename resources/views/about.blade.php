<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - EXPORTANI</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        exportani: {
                            dark: '#005700',
                            primary: '#2F7226',
                            mint: '#74C690',
                            teal: '#3AA68B',
                            accent: '#1F6F63',
                            background: '#F4F6F5',
                            text: '#1F2937',
                            secondaryText: '#6B7280',
                            border: '#E5E7EB',
                        },
                    },
                    borderRadius: {
                        'xl': '12px',
                        '2xl': '16px',
                        '3xl': '24px',
                    },
                },
            },
        };
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F4F6F5;
        }
        .bg-noise-overlay {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 250 250' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="text-exportani-text antialiased">

<!-- NAVBAR -->
<nav class="bg-exportani-dark border-b border-exportani-primary/10 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-8">
        <div class="h-20 flex items-center justify-between">
            <!-- LEFT -->
            <div class="flex items-center gap-10">
                <!-- LOGO -->
                <div class="flex items-center gap-4">
                    <x-application-logo class="w-14 h-14 shrink-0 shadow-lg" />
                    <div>
                        <h1 class="text-white text-xl font-bold tracking-tight">
                            EXPORTANI
                        </h1>
                        <p class="text-exportani-background/80 text-xs font-medium">
                            Petani · Produk · Kerja Sama
                        </p>
                    </div>
                </div>

                <!-- MENU -->
                <div class="hidden lg:flex items-center gap-2">
                    <a href="/" class="text-exportani-background/80 hover:text-white px-4 py-2.5 rounded-xl transition font-semibold text-sm">
                        Home
                    </a>
                    <a href="/about" class="bg-white/15 text-white px-4 py-2.5 rounded-xl font-semibold text-sm">
                        About
                    </a>
                    <a href="/statistik" class="text-exportani-background/80 hover:text-white px-4 py-2.5 rounded-xl transition font-semibold text-sm">
                        Statistik
                    </a>
                </div>
            </div>

            <!-- RIGHT -->
            <div>
                <a href="/login" class="bg-exportani-primary hover:bg-exportani-dark transition text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="relative overflow-hidden bg-gradient-to-br from-exportani-dark via-exportani-primary to-exportani-accent text-white">
    <!-- NOISE PATTERN -->
    <div class="absolute inset-0 bg-noise-overlay opacity-[0.035] pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-8 py-28">
        <div class="max-w-4xl">
            <!-- BADGE -->
            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 px-4 py-2 rounded-2xl backdrop-blur">
                <div class="w-2.5 h-2.5 rounded-full bg-exportani-mint animate-pulse"></div>
                <span class="text-exportani-mint text-xs font-bold uppercase tracking-wider">
                    Tentang Platform
                </span>
            </div>

            <!-- TITLE -->
            <h1 class="mt-8 text-4xl sm:text-5xl leading-tight font-black text-white font-display">
                Platform Digital EXPORTANI Pertanian Indonesia.
            </h1>

            <!-- DESC -->
            <p class="mt-6 text-lg leading-relaxed text-exportani-background/90 max-w-3xl font-medium">
                EXPORTANI hadir sebagai platform digital yang menghubungkan petani dan eksportir secara langsung untuk membangun kerja sama yang lebih modern, efisien, transparan, dan berkelanjutan.
            </p>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-8">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <!-- LEFT -->
            <div class="space-y-6">
                <p class="text-exportani-primary font-bold uppercase tracking-wider text-xs">
                    Tentang Sistem
                </p>
                <h2 class="text-3xl sm:text-4xl font-black leading-tight text-exportani-text font-display tracking-tight">
                    Membangun Ekosistem Kemitraan Digital dari Hulu ke Hilir.
                </h2>
                <p class="text-base leading-relaxed text-exportani-secondaryText">
                    Platform ini dirancang untuk membantu petani memperluas akses pasar dan membantu eksportir menemukan mitra pertanian secara lebih cepat melalui sistem digital yang terintegrasi.
                </p>
                <p class="text-base leading-relaxed text-exportani-secondaryText">
                    Dengan sistem ini, proses kerja sama dapat berjalan lebih transparan, efisien, dan mudah dipantau secara realtime.
                </p>
            </div>

            <!-- RIGHT -->
            <div class="bg-white border border-exportani-border rounded-3xl p-10 shadow-sm">
                <div class="grid grid-cols-2 gap-6">
                    <!-- CARD -->
                    <div class="bg-exportani-background border border-exportani-border rounded-2xl p-6 hover:shadow-sm transition">
                        <div class="w-14 h-14 rounded-2xl bg-exportani-mint/15 border border-exportani-mint/20 flex items-center justify-center text-exportani-accent shadow-sm">
                            <svg class="h-6 w-6 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m11.314 11.314l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-bold text-exportani-text font-display">
                            Petani
                        </h3>
                        <p class="mt-2 text-exportani-secondaryText leading-relaxed text-xs">
                            Mengunggah hasil pertanian secara langsung.
                        </p>
                    </div>

                    <!-- CARD -->
                    <div class="bg-exportani-background border border-exportani-border rounded-2xl p-6 hover:shadow-sm transition">
                        <div class="w-14 h-14 rounded-2xl bg-exportani-mint/15 border border-exportani-mint/20 flex items-center justify-center text-exportani-accent shadow-sm">
                            <svg class="h-6 w-6 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2a2.5 2.5 0 002.5-2.5V8a2 2 0 00-2-2h-.5A2.5 2.5 0 0113 3.5V2.055m-6 17A9 9 0 1022.945 12H18a2 2 0 01-2-2V8a2 2 0 00-2-2h-3V3.5a1 1 0 00-1-1z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-bold text-exportani-text font-display">
                            Eksportir
                        </h3>
                        <p class="mt-2 text-exportani-secondaryText leading-relaxed text-xs">
                            Mencari mitra pertanian untuk ekspor.
                        </p>
                    </div>

                    <!-- CARD -->
                    <div class="bg-exportani-background border border-exportani-border rounded-2xl p-6 hover:shadow-sm transition">
                        <div class="w-14 h-14 rounded-2xl bg-exportani-mint/15 border border-exportani-mint/20 flex items-center justify-center text-exportani-accent shadow-sm">
                            <svg class="h-6 w-6 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-bold text-exportani-text font-display">
                            Kerja Sama
                        </h3>
                        <p class="mt-2 text-exportani-secondaryText leading-relaxed text-xs">
                            Pengajuan kemitraan dilakukan secara digital.
                        </p>
                    </div>

                    <!-- CARD -->
                    <div class="bg-exportani-background border border-exportani-border rounded-2xl p-6 hover:shadow-sm transition">
                        <div class="w-14 h-14 rounded-2xl bg-exportani-mint/15 border border-exportani-mint/20 flex items-center justify-center text-exportani-accent shadow-sm">
                            <svg class="h-6 w-6 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-bold text-exportani-text font-display">
                            Monitoring
                        </h3>
                        <p class="mt-2 text-exportani-secondaryText leading-relaxed text-xs">
                            Aktivitas platform dipantau realtime.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VISI MISI -->
<section class="bg-white border-y border-exportani-border py-24">
    <div class="max-w-7xl mx-auto px-8">
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- VISI -->
            <div class="bg-exportani-background border border-exportani-border rounded-3xl p-10 shadow-sm space-y-6">
                <p class="text-exportani-primary font-bold uppercase tracking-wider text-xs">Visi</p>
                <h2 class="text-3xl font-black text-exportani-text font-display tracking-tight">
                    Menjadi Platform Kemitraan Pertanian Digital Terpercaya.
                </h2>
                <p class="text-base leading-relaxed text-exportani-secondaryText">
                    Membantu menciptakan sistem distribusi pertanian yang lebih efisien, transparan, dan berkelanjutan melalui teknologi digital.
                </p>
            </div>

            <!-- MISI -->
            <div class="rounded-3xl p-10 text-white relative overflow-hidden bg-gradient-to-br from-exportani-dark via-exportani-primary to-exportani-accent">
                <!-- NOISE PATTERN -->
                <div class="absolute inset-0 bg-noise-overlay opacity-[0.035] pointer-events-none"></div>
                <div class="relative z-10 space-y-6">
                    <p class="text-exportani-mint font-bold uppercase tracking-wider text-xs">Misi</p>
                    <h2 class="text-3xl font-black leading-tight font-display tracking-tight">
                        Menghubungkan Petani dan Eksportir Secara Langsung.
                    </h2>
                    <ul class="space-y-4">
                        <li class="flex gap-4 items-start">
                            <div class="w-2.5 h-2.5 rounded-full bg-exportani-mint mt-2 shrink-0"></div>
                            <p class="text-exportani-background leading-relaxed text-sm">Mempermudah akses pasar ekspor bagi petani lokal.</p>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-2.5 h-2.5 rounded-full bg-exportani-mint mt-2 shrink-0"></div>
                            <p class="text-exportani-background leading-relaxed text-sm">Membantu eksportir menemukan mitra pertanian yang kredibel.</p>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-2.5 h-2.5 rounded-full bg-exportani-mint mt-2 shrink-0"></div>
                            <p class="text-exportani-background leading-relaxed text-sm">Mendukung pertumbuhan ekonomi pertanian digital Indonesia.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-10 relative bg-gradient-to-r from-exportani-dark to-exportani-accent">
    <!-- NOISE PATTERN -->
    <div class="absolute inset-0 bg-noise-overlay opacity-[0.035] pointer-events-none"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-8 flex flex-col lg:flex-row items-center justify-between gap-6">
        <div>
            <h2 class="text-xl text-white font-bold tracking-tight">EXPORTANI</h2>
            <p class="mt-1 text-xs text-exportani-background/80">Platform Digital Kemitraan Pertanian Indonesia</p>
        </div>
        <div class="text-exportani-background/60 text-xs font-semibold">
            © 2026 EXPORTANI. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
