<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kemitraan Ekspor</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>

        body{
            font-family: 'Inter', sans-serif;
            background: #f5f5f4;
        }

        .heading-serif{
            font-family: 'Merriweather', serif;
        }

        .pattern-bg{
            background-color: #064e3b;
            background-image:
            linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 32px 32px;
        }

    </style>

</head>

<body>

<!-- NAVBAR -->
<nav class="pattern-bg border-b border-emerald-800 sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-8">

        <div class="h-20 flex items-center justify-between">

            <!-- LEFT -->
            <div class="flex items-center gap-10">

                <!-- LOGO -->
                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg">

                        <svg width="28" fill="white" viewBox="0 0 24 24">
                            <path d="M12 2L4 7v10l8 5 8-5V7l-8-5z"/>
                        </svg>

                    </div>

                    <div>

                        <h1 class="text-white text-2xl font-bold heading-serif">
                            Kemitraan Ekspor
                        </h1>

                        <p class="text-emerald-100 text-sm">
                            Petani · Produk · Kerja Sama
                        </p>

                    </div>

                </div>

                <!-- MENU -->
                <div class="hidden lg:flex items-center gap-4">

                    <a href="/"
                       class="bg-white/10 text-white px-5 py-3 rounded-xl font-semibold">

                        Home

                    </a>

                    <a href="/about"
                       class="text-emerald-100 hover:text-white px-5 py-3 rounded-xl transition">

                        About

                    </a>

                    <a href="/statistik"
                       class="text-emerald-100 hover:text-white px-5 py-3 rounded-xl transition">

                        Statistik

                    </a>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-4">

                <a href="/login"
                   class="bg-emerald-600 hover:bg-emerald-500 transition text-white px-6 py-3 rounded-xl font-semibold">

                    Login

                </a>

            </div>

        </div>

    </div>

</nav>

<!-- HERO -->
<section class="grid lg:grid-cols-2 min-h-[90vh]">

    <!-- LEFT -->
    <div class="pattern-bg relative overflow-hidden flex items-center">

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#022c22]/70 via-[#064e3b]/85 to-[#065f46]/90"></div>

        <!-- CONTENT -->
        <div class="relative z-10 px-16 py-20">

            <!-- BADGE -->
            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 px-5 py-3 rounded-2xl backdrop-blur">

                <div class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></div>

                <span class="text-emerald-100 text-sm font-medium">
                    Platform Digital Kemitraan Ekspor
                </span>

            </div>

            <!-- TITLE -->
            <h1 class="mt-10 heading-serif text-6xl leading-tight font-black text-white">

                Bangun Koneksi
                Langsung Antara
                Petani dan Eksportir.

            </h1>

            <!-- DESC -->
            <p class="mt-8 text-xl leading-relaxed text-emerald-100 max-w-2xl">

                Sistem kemitraan digital modern untuk membantu
                distribusi hasil pertanian menuju pasar ekspor
                secara lebih efisien, transparan, dan berkelanjutan.

            </p>

            <!-- BUTTON -->
            <div class="mt-12 flex flex-wrap gap-4">

                <a href="/register"
                   class="bg-emerald-500 hover:bg-emerald-400 transition text-white px-8 py-4 rounded-2xl font-semibold">

                    Mulai Sekarang

                </a>

                <a href="/about"
                   class="bg-white/10 hover:bg-white/20 transition text-white px-8 py-4 rounded-2xl font-semibold border border-white/10">

                    Pelajari Platform

                </a>

            </div>

            <!-- STATS -->
            <div class="mt-16 grid grid-cols-3 gap-10">

                <div>

                    <h2 class="text-4xl font-black text-white">
                        250+
                    </h2>

                    <p class="mt-2 text-emerald-100">
                        Produk Pertanian
                    </p>

                </div>

                <div>

                    <h2 class="text-4xl font-black text-white">
                        120+
                    </h2>

                    <p class="mt-2 text-emerald-100">
                        Petani Aktif
                    </p>

                </div>

                <div>

                    <h2 class="text-4xl font-black text-white">
                        400+
                    </h2>

                    <p class="mt-2 text-emerald-100">
                        Kerja Sama
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="bg-[#f5f5f4] flex items-center justify-center px-10 py-20">

        <!-- DASHBOARD -->
        <div class="w-full max-w-2xl bg-white rounded-[35px] border border-gray-200 overflow-hidden shadow-sm">

            <!-- HEADER -->
            <div class="pattern-bg px-8 py-6 border-b border-emerald-800">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-2xl font-bold text-white">
                            Dashboard Kemitraan
                        </h2>

                        <p class="mt-2 text-emerald-100">
                            Monitoring aktivitas platform
                        </p>

                    </div>

                    <div class="bg-white/10 text-white px-5 py-3 rounded-xl">
                        Active
                    </div>

                </div>

            </div>

            <!-- CONTENT -->
            <div class="p-8">

                <!-- TOP -->
                <div class="grid grid-cols-2 gap-5">

                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">

                        <p class="text-gray-500 text-sm">
                            Total Produk
                        </p>

                        <h2 class="mt-4 text-5xl font-bold text-gray-900">
                            250
                        </h2>

                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">

                        <p class="text-gray-500 text-sm">
                            Kerja Sama
                        </p>

                        <h2 class="mt-4 text-5xl font-bold text-gray-900">
                            400
                        </h2>

                    </div>

                </div>

                <!-- ACTIVITY -->
                <div class="mt-8">

                    <h2 class="text-xl font-bold text-gray-900">
                        Aktivitas Platform
                    </h2>

                    <div class="mt-6 space-y-4">

                        <!-- ITEM -->
                        <div class="flex items-center justify-between bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4">

                            <div>

                                <p class="font-semibold text-gray-800">
                                    Produk Cabai Merah
                                </p>

                                <p class="text-sm text-gray-500">
                                    Produk berhasil dipublish
                                </p>

                            </div>

                            <span class="text-sm text-gray-400">
                                2m ago
                            </span>

                        </div>

                        <!-- ITEM -->
                        <div class="flex items-center justify-between bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4">

                            <div>

                                <p class="font-semibold text-gray-800">
                                    Export Indo Group
                                </p>

                                <p class="text-sm text-gray-500">
                                    Pengajuan kerja sama baru
                                </p>

                            </div>

                            <span class="text-sm text-gray-400">
                                15m ago
                            </span>

                        </div>

                        <!-- ITEM -->
                        <div class="flex items-center justify-between bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4">

                            <div>

                                <p class="font-semibold text-gray-800">
                                    Trusted Farmer
                                </p>

                                <p class="text-sm text-gray-500">
                                    Status verifikasi diperbarui
                                </p>

                            </div>

                            <span class="text-sm text-gray-400">
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
<section class="py-24 bg-white border-t border-gray-200">

    <div class="max-w-7xl mx-auto px-8">

        <!-- TITLE -->
        <div class="text-center">

            <h2 class="heading-serif text-5xl font-black text-gray-900">

                Sistem Kemitraan
                Pertanian Modern

            </h2>

            <p class="mt-6 text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed">

                Platform dirancang untuk membantu petani dan eksportir
                membangun koneksi bisnis secara lebih efisien dan profesional.

            </p>

        </div>

        <!-- CARD -->
        <div class="grid lg:grid-cols-3 gap-6 mt-16">

            <!-- ITEM -->
            <div class="bg-[#f8faf9] border border-gray-100 rounded-[30px] p-8">

                <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                    🌾
                </div>

                <h3 class="mt-8 text-2xl font-bold text-gray-900">
                    Upload Produk
                </h3>

                <p class="mt-4 leading-relaxed text-gray-500">

                    Petani dapat menambahkan produk pertanian
                    secara langsung ke dalam platform.

                </p>

            </div>

            <!-- ITEM -->
            <div class="bg-[#f8faf9] border border-gray-100 rounded-[30px] p-8">

                <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                    🤝
                </div>

                <h3 class="mt-8 text-2xl font-bold text-gray-900">
                    Kerja Sama Digital
                </h3>

                <p class="mt-4 leading-relaxed text-gray-500">

                    Eksportir dapat mengajukan kemitraan
                    secara langsung melalui sistem.

                </p>

            </div>

            <!-- ITEM -->
            <div class="bg-[#f8faf9] border border-gray-100 rounded-[30px] p-8">

                <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                    🚢
                </div>

                <h3 class="mt-8 text-2xl font-bold text-gray-900">
                    Akses Pasar Ekspor
                </h3>

                <p class="mt-4 leading-relaxed text-gray-500">

                    Membantu memperluas distribusi hasil pertanian
                    menuju pasar internasional.

                </p>

            </div>

        </div>

    </div>

<!-- ABOUT SECTION -->
<section id="about" class="py-24 bg-[#f8faf9]">
    <div class="max-w-7xl mx-auto px-8 grid lg:grid-cols-2 gap-16 items-center">
        <div>
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 text-sm font-semibold mb-6">
                Tentang Platform
            </div>
            <h2 class="heading-serif text-4xl font-black text-gray-900 leading-tight">
                Membuka Akses Pasar Global untuk Petani Lokal
            </h2>
            <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                Exportani adalah platform digital yang didedikasikan untuk menghubungkan petani komoditas unggulan Indonesia langsung dengan para eksportir terpercaya. Kami memotong rantai pasok yang panjang, memastikan petani mendapatkan nilai yang adil, dan eksportir mendapatkan produk berkualitas secara efisien.
            </p>
            <div class="mt-8 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-700 font-medium">Transparansi Kualitas dan Harga</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-700 font-medium">Sistem Pengajuan Kerja Sama Instan</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-700 font-medium">Verifikasi Akun yang Ketat</span>
                </div>
            </div>
        </div>
        <div class="relative">
            <div class="absolute inset-0 bg-emerald-600 rounded-[40px] rotate-3 opacity-20"></div>
            <img src="https://images.unsplash.com/photo-1595841696677-6489ff3f8cd1?q=80&w=800&auto=format&fit=crop" alt="Petani Indonesia" class="relative z-10 w-full h-[500px] object-cover rounded-[40px] shadow-xl">
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-16">
            <h2 class="heading-serif text-4xl font-black text-gray-900">Bagaimana Cara Kerjanya?</h2>
            <p class="mt-4 text-xl text-gray-500">Proses sederhana dari hulu ke hilir</p>
        </div>

        <div class="grid md:grid-cols-4 gap-8 relative">
            <!-- Line connector -->
            <div class="hidden md:block absolute top-12 left-1/8 right-1/8 h-0.5 bg-gray-200 z-0"></div>

            <div class="relative z-10 text-center">
                <div class="w-24 h-24 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-3xl font-bold shadow-lg shadow-emerald-600/30 mb-6">
                    1
                </div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Akun</h3>
                <p class="mt-2 text-gray-500">Pilih role sebagai Petani atau Eksportir dan lengkapi profil Anda.</p>
            </div>

            <div class="relative z-10 text-center">
                <div class="w-24 h-24 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-3xl font-bold shadow-lg shadow-emerald-600/30 mb-6">
                    2
                </div>
                <h3 class="text-xl font-bold text-gray-900">Upload Produk</h3>
                <p class="mt-2 text-gray-500">Petani mempublikasikan produk unggulan dengan detail kapasitas dan harga.</p>
            </div>

            <div class="relative z-10 text-center">
                <div class="w-24 h-24 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-3xl font-bold shadow-lg shadow-emerald-600/30 mb-6">
                    3
                </div>
                <h3 class="text-xl font-bold text-gray-900">Cari & Ajukan</h3>
                <p class="mt-2 text-gray-500">Eksportir mencari produk via platform dan menekan tombol 'Ajukan Kerja Sama'.</p>
            </div>

            <div class="relative z-10 text-center">
                <div class="w-24 h-24 mx-auto bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-3xl font-bold shadow-lg shadow-emerald-600/30 mb-6">
                    4
                </div>
                <h3 class="text-xl font-bold text-gray-900">Terima Kemitraan</h3>
                <p class="mt-2 text-gray-500">Petani menerima pengajuan, dan proses ekspor dapat dilanjutkan secara offline.</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-[#022c22] border-t border-emerald-900 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center">
                        <svg width="20" fill="white" viewBox="0 0 24 24"><path d="M12 2L4 7v10l8 5 8-5V7l-8-5z"/></svg>
                    </div>
                    <h2 class="text-white text-xl font-bold heading-serif">Exportani</h2>
                </div>
                <p class="text-emerald-200/60 max-w-sm leading-relaxed">
                    Platform kemitraan B2B yang mendigitalkan proses pencarian produk pertanian lokal untuk dihubungkan dengan buyer eksportir global.
                </p>
            </div>
            
            <div>
                <h3 class="text-white font-semibold mb-4">Navigasi</h3>
                <ul class="space-y-3">
                    <li><a href="/" class="text-emerald-200/60 hover:text-white transition">Beranda</a></li>
                    <li><a href="#about" class="text-emerald-200/60 hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="/login" class="text-emerald-200/60 hover:text-white transition">Masuk Akun</a></li>
                    <li><a href="/register" class="text-emerald-200/60 hover:text-white transition">Daftar Kemitraan</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">Bantuan</h3>
                <ul class="space-y-3">
                    <li><span class="text-emerald-200/60">Panduan Petani</span></li>
                    <li><span class="text-emerald-200/60">Panduan Eksportir</span></li>
                    <li><span class="text-emerald-200/60">FAQ</span></li>
                    <li><span class="text-emerald-200/60">Kontak: support@exportani.com</span></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-emerald-800/50 pt-8 flex flex-col md:flex-row items-center justify-between">
            <p class="text-emerald-200/40 text-sm">
                &copy; {{ date('Y') }} Exportani. Hak Cipta Dilindungi.
            </p>
            <div class="flex items-center gap-4 mt-4 md:mt-0">
                <span class="text-emerald-200/40 text-sm hover:text-white cursor-pointer transition">Kebijakan Privasi</span>
                <span class="text-emerald-200/40 text-sm hover:text-white cursor-pointer transition">Syarat & Ketentuan</span>
            </div>
        </div>
    </div>
</footer>

</body>
</html>