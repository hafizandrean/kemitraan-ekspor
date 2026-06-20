<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPORTANI</title>

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
                    <a href="/" class="bg-white/15 text-white px-4 py-2.5 rounded-xl font-semibold text-sm">
                        Home
                    </a>
                    <a href="/about" class="text-exportani-background/80 hover:text-white px-4 py-2.5 rounded-xl transition font-semibold text-sm">
                        About
                    </a>
                    <a href="/statistik" class="text-exportani-background/80 hover:text-white px-4 py-2.5 rounded-xl transition font-semibold text-sm">
                        Statistik
                    </a>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-4">
                <a href="/login" class="bg-exportani-primary hover:bg-exportani-dark transition text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="grid lg:grid-cols-2 min-h-[90vh]">
    <!-- LEFT -->
    <div class="relative overflow-hidden flex items-center bg-gradient-to-br from-exportani-dark via-exportani-primary to-exportani-accent text-white">
        <!-- NOISE PATTERN -->
        <div class="absolute inset-0 bg-noise-overlay opacity-[0.035] pointer-events-none"></div>

        <!-- CONTENT -->
        <div class="relative z-10 px-8 sm:px-16 py-20">
            <!-- BADGE -->
            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 px-4 py-2 rounded-2xl backdrop-blur">
                <div class="w-2.5 h-2.5 rounded-full bg-exportani-mint animate-pulse"></div>
                <span class="text-exportani-mint text-xs font-bold uppercase tracking-wider">
                    Platform Digital EXPORTANI
                </span>
            </div>

            <!-- TITLE -->
            <h1 class="mt-8 text-4xl sm:text-5xl leading-tight font-black text-white font-display">
                Bangun Koneksi Langsung Antara Petani dan Eksportir.
            </h1>

            <!-- DESC -->
            <p class="mt-6 text-lg leading-relaxed text-exportani-background/90 max-w-2xl font-medium">
                Sistem kemitraan digital modern untuk membantu distribusi hasil pertanian menuju pasar ekspor secara lebih efisien, transparan, dan berkelanjutan.
            </p>

            <!-- BUTTON -->
            <div class="mt-10 flex flex-wrap gap-4">
                <a href="/register" class="bg-exportani-primary hover:bg-exportani-dark transition text-white px-8 py-4 rounded-2xl font-bold shadow-md hover:shadow-lg">
                    Mulai Sekarang
                </a>
                <a href="/about" class="bg-white/10 hover:bg-white/20 transition text-white px-8 py-4 rounded-2xl font-bold border border-white/15">
                    Pelajari Platform
                </a>
            </div>

            <!-- STATS -->
            <div class="mt-16 grid grid-cols-3 gap-6 border-t border-white/10 pt-10">
                <div>
                    <h2 class="text-3xl font-black text-white">250+</h2>
                    <p class="mt-1 text-xs text-exportani-background/70 font-semibold uppercase tracking-wider">Produk Pertanian</p>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">120+</h2>
                    <p class="mt-1 text-xs text-exportani-background/70 font-semibold uppercase tracking-wider">Petani Aktif</p>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white">400+</h2>
                    <p class="mt-1 text-xs text-exportani-background/70 font-semibold uppercase tracking-wider">Kerja Sama</p>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="bg-[#F4F6F5] flex items-center justify-center px-4 sm:px-10 py-20">
        <!-- DASHBOARD -->
        <div class="w-full max-w-2xl bg-white rounded-3xl border border-exportani-border overflow-hidden shadow-sm">
            <!-- HEADER -->
            <div class="relative bg-gradient-to-r from-exportani-dark to-exportani-accent px-8 py-6 border-b border-exportani-primary/10 overflow-hidden">
                <!-- NOISE PATTERN -->
                <div class="absolute inset-0 bg-noise-overlay opacity-[0.035] pointer-events-none"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white font-display">
                            Dashboard Kemitraan
                        </h2>
                        <p class="mt-0.5 text-xs text-exportani-background/80 font-medium">
                            Monitoring aktivitas platform
                        </p>
                    </div>
                    <div class="bg-white/15 text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider">
                        Active
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="p-8 space-y-8">
                <!-- TOP -->
                <div class="grid grid-cols-2 gap-5">
                    <div class="bg-exportani-background border border-exportani-border rounded-2xl p-6 shadow-sm">
                        <p class="text-exportani-secondaryText text-xs font-bold uppercase tracking-wider">
                            Total Produk
                        </p>
                        <h2 class="mt-2 text-4xl font-extrabold text-exportani-text">
                            250
                        </h2>
                    </div>
                    <div class="bg-exportani-background border border-exportani-border rounded-2xl p-6 shadow-sm">
                        <p class="text-exportani-secondaryText text-xs font-bold uppercase tracking-wider">
                            Kerja Sama
                        </p>
                        <h2 class="mt-2 text-4xl font-extrabold text-exportani-text">
                            400
                        </h2>
                    </div>
                </div>

                <!-- ACTIVITY -->
                <div>
                    <h2 class="text-base font-bold text-exportani-text uppercase tracking-wider">
                        Aktivitas Platform
                    </h2>
                    <div class="mt-4 space-y-3">
                        <!-- ITEM -->
                        <div class="flex items-center justify-between bg-exportani-background/50 border border-exportani-border rounded-2xl px-5 py-4">
                            <div>
                                <p class="font-bold text-exportani-text text-sm">
                                    Produk Cabai Merah
                                </p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5">
                                    Produk berhasil dipublish
                                </p>
                            </div>
                            <span class="text-xs text-exportani-secondaryText/70 font-medium">
                                2m ago
                            </span>
                        </div>

                        <!-- ITEM -->
                        <div class="flex items-center justify-between bg-exportani-background/50 border border-exportani-border rounded-2xl px-5 py-4">
                            <div>
                                <p class="font-bold text-exportani-text text-sm">
                                    Export Indo Group
                                </p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5">
                                    Pengajuan kerja sama baru
                                </p>
                            </div>
                            <span class="text-xs text-exportani-secondaryText/70 font-medium">
                                15m ago
                            </span>
                        </div>

                        <!-- ITEM -->
                        <div class="flex items-center justify-between bg-exportani-background/50 border border-exportani-border rounded-2xl px-5 py-4">
                            <div>
                                <p class="font-bold text-exportani-text text-sm">
                                    Petani Tepercaya
                                </p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5">
                                    Status verifikasi diperbarui
                                </p>
                            </div>
                            <span class="text-xs text-exportani-secondaryText/70 font-medium">
                                1h ago
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURE -->
<section class="py-24 bg-white border-t border-exportani-border">
    <div class="max-w-7xl mx-auto px-8">
        <!-- TITLE -->
        <div class="text-center">
            <h2 class="text-3xl sm:text-4xl font-black text-exportani-text tracking-tight font-display">
                Sistem Kemitraan Pertanian Modern
            </h2>
            <p class="mt-4 text-base text-exportani-secondaryText max-w-3xl mx-auto leading-relaxed">
                Platform dirancang untuk membantu petani dan eksportir membangun koneksi bisnis secara lebih efisien dan profesional.
            </p>
        </div>

        <!-- CARD GRID -->
        <div class="grid lg:grid-cols-3 gap-6 mt-16">
            <!-- ITEM -->
            <div class="bg-exportani-background/45 border border-exportani-border rounded-2xl p-8 hover:shadow-md hover:border-exportani-mint transition duration-200">
                <div class="w-16 h-16 rounded-2xl bg-exportani-mint/15 border border-exportani-mint/20 flex items-center justify-center text-exportani-accent shadow-sm">
                    <svg class="h-8 w-8 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-bold text-exportani-text font-display">
                    Upload Produk
                </h3>
                <p class="mt-3 text-sm leading-relaxed text-exportani-secondaryText">
                    Petani dapat menambahkan produk pertanian secara langsung ke dalam platform secara realtime.
                </p>
            </div>

            <!-- ITEM -->
            <div class="bg-exportani-background/45 border border-exportani-border rounded-2xl p-8 hover:shadow-md hover:border-exportani-mint transition duration-200">
                <div class="w-16 h-16 rounded-2xl bg-exportani-mint/15 border border-exportani-mint/20 flex items-center justify-center text-exportani-accent shadow-sm">
                    <svg class="h-8 w-8 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-bold text-exportani-text font-display">
                    Kerja Sama Digital
                </h3>
                <p class="mt-3 text-sm leading-relaxed text-exportani-secondaryText">
                    Eksportir dapat mengajukan kemitraan secara langsung melalui sistem alur kontrak yang transparan.
                </p>
            </div>

            <!-- ITEM -->
            <div class="bg-exportani-background/45 border border-exportani-border rounded-2xl p-8 hover:shadow-md hover:border-exportani-mint transition duration-200">
                <div class="w-16 h-16 rounded-2xl bg-exportani-mint/15 border border-exportani-mint/20 flex items-center justify-center text-exportani-accent shadow-sm">
                    <svg class="h-8 w-8 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2a2.5 2.5 0 002.5-2.5V8a2 2 0 00-2-2h-.5A2.5 2.5 0 0113 3.5V2.055m-6 17A9 9 0 1022.945 12H18a2 2 0 01-2-2V8a2 2 0 00-2-2h-3V3.5a1 1 0 00-1-1z" />
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-bold text-exportani-text font-display">
                    Akses Pasar Ekspor
                </h3>
                <p class="mt-3 text-sm leading-relaxed text-exportani-secondaryText">
                    Membantu memperluas distribusi hasil pertanian komoditas unggulan Indonesia menuju pasar internasional.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- KATEGORI PRODUK -->
@if(isset($categories) && $categories->isNotEmpty())
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-exportani-text font-display tracking-tight">Kategori Produk</h2>
            <p class="mt-3 text-base text-exportani-secondaryText">Komoditas unggulan yang tersedia di platform</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <div class="rounded-2xl border border-exportani-border bg-white p-5 text-center hover:border-exportani-mint hover:shadow-sm transition duration-150">
                    <p class="font-bold text-exportani-text text-sm">{{ $category->name }}</p>
                    <p class="mt-1.5 text-xs text-exportani-secondaryText">{{ $category->products_count }} produk</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- REKOMENDASI PRODUK -->
@if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty())
<section class="py-20 bg-exportani-background">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-exportani-text font-display tracking-tight">Produk Rekomendasi</h2>
            <p class="mt-3 text-base text-exportani-secondaryText">Pilihan terbaik dari admin untuk eksportir</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($recommendedProducts as $product)
                <div class="rounded-2xl bg-white border border-exportani-border shadow-sm overflow-hidden flex flex-col justify-between">
                    <div class="h-48 bg-exportani-background border-b border-exportani-border flex items-center justify-center text-exportani-secondaryText font-semibold">
                        {{ $product->category?->name ?? 'Komoditas' }}
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex flex-wrap gap-1.5">
                            <span class="inline-block rounded-full bg-amber-50 border border-amber-200/50 px-2.5 py-0.5 text-[10px] font-bold text-amber-800 uppercase tracking-wide">Rekomendasi</span>
                            @if($product->owner?->is_trusted_petani)
                                <span class="inline-flex items-center gap-0.5 rounded-full bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide">Petani Tepercaya</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-exportani-text truncate">{{ $product->nama_produk }}</h3>
                            <p class="mt-1 text-exportani-primary font-bold">Rp{{ number_format($product->harga, 0, ',', '.') }}</p>
                            <p class="mt-2 text-xs text-exportani-secondaryText">{{ $product->lokasi }} · {{ $product->owner?->name }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-12 text-center">
            <a href="/register" class="inline-flex items-center rounded-xl bg-exportani-primary hover:bg-exportani-dark text-white px-6 py-3 font-bold text-sm shadow-sm transition">Daftar untuk melihat semua produk</a>
        </div>
    </div>
</section>
@endif

<!-- PETANI TEPERCAYA -->
@if(isset($trustedPetaniCount))
<section class="py-16 bg-gradient-to-br from-exportani-dark via-exportani-primary to-exportani-accent text-white relative overflow-hidden">
    <!-- NOISE PATTERN -->
    <div class="absolute inset-0 bg-noise-overlay opacity-[0.035] pointer-events-none"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-8 text-center space-y-4">
        <h2 class="text-2xl sm:text-3xl font-black font-display tracking-tight">Sistem Petani Tepercaya</h2>
        <p class="text-exportani-background/80 max-w-2xl mx-auto text-sm leading-relaxed">
            Petani terverifikasi oleh admin mendapat lencana keanggotaan khusus untuk meyakinkan eksportir dalam mengajukan kemitraan.
        </p>
        <div class="pt-4">
            <p class="text-5xl font-black text-exportani-mint tracking-tight">{{ $trustedPetaniCount }}</p>
            <p class="text-exportani-background/60 text-xs font-bold uppercase tracking-wider mt-1.5">petani tepercaya saat ini</p>
        </div>
    </div>
</section>
@endif

<!-- ABOUT SECTION -->
<section id="about" class="py-24 bg-exportani-background">
    <div class="max-w-7xl mx-auto px-8 grid lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 text-xs font-bold uppercase tracking-wider">
                Tentang Platform
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-exportani-text leading-tight font-display tracking-tight">
                Membuka Akses Pasar Global untuk Petani Lokal
            </h2>
            <p class="text-base text-exportani-secondaryText leading-relaxed">
                EXPORTANI adalah platform digital yang didedikasikan untuk menghubungkan petani komoditas unggulan Indonesia langsung dengan para eksportir terpercaya. Kami memotong rantai pasok yang panjang, memastikan petani mendapatkan nilai yang adil, dan eksportir mendapatkan produk berkualitas secara efisien.
            </p>
            <div class="space-y-4 pt-2">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-exportani-mint/15 flex items-center justify-center text-exportani-accent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-exportani-text font-bold text-sm">Transparansi Kualitas dan Harga</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-exportani-mint/15 flex items-center justify-center text-exportani-accent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-exportani-text font-bold text-sm">Sistem Pengajuan Kerja Sama Instan</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-exportani-mint/15 flex items-center justify-center text-exportani-accent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-exportani-text font-bold text-sm">Verifikasi Akun yang Ketat</span>
                </div>
            </div>
        </div>
        <div class="relative">
            <div class="absolute inset-0 bg-exportani-primary rounded-3xl rotate-3 opacity-10"></div>
            <img 
src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80&w=1200&auto=format&fit=crop"
alt="Kemitraan Petani Indonesia"
class="relative z-10 w-full h-[450px] object-cover rounded-3xl shadow-sm">
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-exportani-text font-display tracking-tight">Bagaimana Cara Kerjanya?</h2>
            <p class="mt-3 text-base text-exportani-secondaryText">Proses sederhana dari hulu ke hilir</p>
        </div>

        <div class="grid md:grid-cols-4 gap-8 relative">
            <!-- Line connector -->
            <div class="hidden md:block absolute top-12 left-1/8 right-1/8 h-0.5 bg-exportani-border z-0"></div>

            <div class="relative z-10 text-center space-y-4">
                <div class="w-24 h-24 mx-auto bg-exportani-primary text-white rounded-2xl flex items-center justify-center text-3xl font-extrabold shadow-sm shadow-exportani-primary/10">
                    1
                </div>
                <h3 class="text-lg font-bold text-exportani-text font-display">Daftar Akun</h3>
                <p class="text-sm text-exportani-secondaryText leading-relaxed">Pilih role sebagai Petani atau Eksportir dan lengkapi profil Anda.</p>
            </div>

            <div class="relative z-10 text-center space-y-4">
                <div class="w-24 h-24 mx-auto bg-exportani-primary text-white rounded-2xl flex items-center justify-center text-3xl font-extrabold shadow-sm shadow-exportani-primary/10">
                    2
                </div>
                <h3 class="text-lg font-bold text-exportani-text font-display">Upload Produk</h3>
                <p class="text-sm text-exportani-secondaryText leading-relaxed">Petani mempublikasikan produk unggulan dengan detail kapasitas dan harga.</p>
            </div>

            <div class="relative z-10 text-center space-y-4">
                <div class="w-24 h-24 mx-auto bg-exportani-primary text-white rounded-2xl flex items-center justify-center text-3xl font-extrabold shadow-sm shadow-exportani-primary/10">
                    3
                </div>
                <h3 class="text-lg font-bold text-exportani-text font-display">Cari & Ajukan</h3>
                <p class="text-sm text-exportani-secondaryText leading-relaxed">Eksportir mencari produk via platform dan menekan tombol 'Ajukan Kerja Sama'.</p>
            </div>

            <div class="relative z-10 text-center space-y-4">
                <div class="w-24 h-24 mx-auto bg-exportani-primary text-white rounded-2xl flex items-center justify-center text-3xl font-extrabold shadow-sm shadow-exportani-primary/10">
                    4
                </div>
                <h3 class="text-lg font-bold text-exportani-text font-display">Terima Kemitraan</h3>
                <p class="text-sm text-exportani-secondaryText leading-relaxed">Petani menerima pengajuan, dan proses ekspor dapat dilanjutkan secara offline.</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-[#002f00] border-t border-exportani-primary/20 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-2 space-y-4">
                <div class="flex items-center gap-3">
                    <x-application-logo class="w-10 h-10 shrink-0" />
                    <h2 class="text-white text-xl font-bold tracking-tight">EXPORTANI</h2>
                </div>
                <p class="text-exportani-background/60 max-w-sm text-sm leading-relaxed">
                    Platform kemitraan B2B yang mendigitalkan proses pencarian produk pertanian lokal untuk dihubungkan dengan buyer eksportir global.
                </p>
            </div>
            
            <div>
                <h3 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Navigasi</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="/" class="text-exportani-background/60 hover:text-white transition">Beranda</a></li>
                    <li><a href="#about" class="text-exportani-background/60 hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="/login" class="text-exportani-background/60 hover:text-white transition">Masuk Akun</a></li>
                    <li><a href="/register" class="text-exportani-background/60 hover:text-white transition">Daftar Kemitraan</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Bantuan</h3>
                <ul class="space-y-3 text-sm text-exportani-background/60">
                    <li><span>Panduan Petani</span></li>
                    <li><span>Panduan Eksportir</span></li>
                    <li><span>FAQ</span></li>
                    <li><span>Kontak: support@EXPORTANI.com</span></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-exportani-primary/10 pt-8 flex flex-col md:flex-row items-center justify-between">
            <p class="text-exportani-background/40 text-xs font-semibold">
                &copy; {{ date('Y') }} EXPORTANI. Hak Cipta Dilindungi.
            </p>
            <div class="flex items-center gap-4 mt-4 md:mt-0">
                <span class="text-exportani-background/40 text-xs font-semibold hover:text-white cursor-pointer transition">Kebijakan Privasi</span>
                <span class="text-exportani-background/40 text-xs font-semibold hover:text-white cursor-pointer transition">Syarat & Ketentuan</span>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
