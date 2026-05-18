<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About - EXPORTANI</title>

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
                            EXPORTANI
                        </h1>

                        <p class="text-emerald-100 text-sm">
                            Petani · Produk · Kerja Sama
                        </p>

                    </div>

                </div>

                <!-- MENU -->
                <div class="hidden lg:flex items-center gap-4">

                    <a href="/"
                       class="text-emerald-100 hover:text-white px-5 py-3 rounded-xl transition">

                        Home

                    </a>

                    <a href="/about"
                       class="bg-white/10 text-white px-5 py-3 rounded-xl font-semibold">

                        About

                    </a>

                    <a href="/statistik"
                       class="text-emerald-100 hover:text-white px-5 py-3 rounded-xl transition">

                        Statistik

                    </a>

                </div>

            </div>

            <!-- RIGHT -->
            <div>

                <a href="/login"
                   class="bg-emerald-600 hover:bg-emerald-500 transition text-white px-6 py-3 rounded-xl font-semibold">

                    Login

                </a>

            </div>

        </div>

    </div>

</nav>

<!-- HERO -->
<section class="pattern-bg relative overflow-hidden">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-gradient-to-br from-[#022c22]/70 via-[#064e3b]/85 to-[#065f46]/90"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-8 py-28">

        <div class="max-w-4xl">

            <!-- BADGE -->
            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 px-5 py-3 rounded-2xl backdrop-blur">

                <div class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></div>

                <span class="text-emerald-100 text-sm font-medium">
                    Tentang Platform
                </span>

            </div>

            <!-- TITLE -->
            <h1 class="mt-10 heading-serif text-6xl leading-tight font-black text-white">

                Platform Digital
                EXPORTANI
                Pertanian Indonesia.

            </h1>

            <!-- DESC -->
            <p class="mt-8 text-xl leading-relaxed text-emerald-100 max-w-3xl">

                EXPORTANI hadir sebagai platform digital
                yang menghubungkan petani dan eksportir secara langsung
                untuk membangun kerja sama yang lebih modern,
                efisien, transparan, dan berkelanjutan.

            </p>

        </div>

    </div>

</section>

<!-- ABOUT -->
<section class="py-24">

    <div class="max-w-7xl mx-auto px-8">

        <div class="grid lg:grid-cols-2 gap-10 items-center">

            <!-- LEFT -->
            <div>

                <p class="text-emerald-700 font-semibold uppercase tracking-widest">
                    Tentang Sistem
                </p>

                <h2 class="mt-6 heading-serif text-5xl font-black leading-tight text-gray-900">

                    Membangun Ekosistem
                    Kemitraan Digital
                    dari Hulu ke Hilir.

                </h2>

                <p class="mt-8 text-lg leading-relaxed text-gray-500">

                    Platform ini dirancang untuk membantu petani
                    memperluas akses pasar dan membantu eksportir
                    menemukan mitra pertanian secara lebih cepat
                    melalui sistem digital yang terintegrasi.

                </p>

                <p class="mt-6 text-lg leading-relaxed text-gray-500">

                    Dengan sistem ini, proses kerja sama dapat berjalan
                    lebih transparan, efisien, dan mudah dipantau
                    secara realtime.

                </p>

            </div>

            <!-- RIGHT -->
            <div class="bg-white border border-gray-100 rounded-[35px] p-10">

                <div class="grid grid-cols-2 gap-6">

                    <!-- CARD -->
                    <div class="bg-[#f8faf9] border border-gray-100 rounded-3xl p-6">

                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                            🌾
                        </div>

                        <h3 class="mt-6 text-xl font-bold text-gray-900">
                            Petani
                        </h3>

                        <p class="mt-3 text-gray-500 leading-relaxed">
                            Mengunggah hasil pertanian secara langsung.
                        </p>

                    </div>

                    <!-- CARD -->
                    <div class="bg-[#f8faf9] border border-gray-100 rounded-3xl p-6">

                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                            🚢
                        </div>

                        <h3 class="mt-6 text-xl font-bold text-gray-900">
                            Eksportir
                        </h3>

                        <p class="mt-3 text-gray-500 leading-relaxed">
                            Mencari mitra pertanian untuk kebutuhan ekspor.
                        </p>

                    </div>

                    <!-- CARD -->
                    <div class="bg-[#f8faf9] border border-gray-100 rounded-3xl p-6">

                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                            🤝
                        </div>

                        <h3 class="mt-6 text-xl font-bold text-gray-900">
                            Kerja Sama
                        </h3>

                        <p class="mt-3 text-gray-500 leading-relaxed">
                            Pengajuan kemitraan dilakukan secara digital.
                        </p>

                    </div>

                    <!-- CARD -->
                    <div class="bg-[#f8faf9] border border-gray-100 rounded-3xl p-6">

                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                            📈
                        </div>

                        <h3 class="mt-6 text-xl font-bold text-gray-900">
                            Monitoring
                        </h3>

                        <p class="mt-3 text-gray-500 leading-relaxed">
                            Aktivitas platform dapat dipantau realtime.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- VISI MISI -->
<section class="bg-white border-y border-gray-200 py-24">

    <div class="max-w-7xl mx-auto px-8">

        <div class="grid lg:grid-cols-2 gap-8">

            <!-- VISI -->
            <div class="bg-[#f8faf9] border border-gray-100 rounded-[35px] p-10">

                <p class="text-emerald-700 font-semibold uppercase tracking-widest">
                    Visi
                </p>

                <h2 class="mt-6 heading-serif text-4xl font-black text-gray-900">

                    Menjadi Platform
                    Kemitraan Pertanian
                    Digital Terpercaya.

                </h2>

                <p class="mt-8 text-lg leading-relaxed text-gray-500">

                    Membantu menciptakan sistem distribusi pertanian
                    yang lebih efisien, transparan, dan berkelanjutan
                    melalui teknologi digital.

                </p>

            </div>

            <!-- MISI -->
            <div class="pattern-bg rounded-[35px] p-10 text-white">

                <p class="text-emerald-100 font-semibold uppercase tracking-widest">
                    Misi
                </p>

                <h2 class="mt-6 heading-serif text-4xl font-black leading-tight">

                    Menghubungkan Petani
                    dan Eksportir Secara
                    Langsung.

                </h2>

                <ul class="mt-8 space-y-5">

                    <li class="flex gap-4">

                        <div class="w-3 h-3 rounded-full bg-emerald-400 mt-2"></div>

                        <p class="text-emerald-100 leading-relaxed">
                            Mempermudah akses pasar ekspor bagi petani.
                        </p>

                    </li>

                    <li class="flex gap-4">

                        <div class="w-3 h-3 rounded-full bg-emerald-400 mt-2"></div>

                        <p class="text-emerald-100 leading-relaxed">
                            Membantu eksportir menemukan mitra pertanian.
                        </p>

                    </li>

                    <li class="flex gap-4">

                        <div class="w-3 h-3 rounded-full bg-emerald-400 mt-2"></div>

                        <p class="text-emerald-100 leading-relaxed">
                            Mendukung pertumbuhan ekonomi pertanian digital.
                        </p>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</section>

<!-- FOOTER -->
<footer class="pattern-bg py-10">

    <div class="max-w-7xl mx-auto px-8">

        <div class="flex flex-col lg:flex-row items-center justify-between gap-6">

            <div>

                <h2 class="text-2xl text-white font-bold heading-serif">
                    EXPORTANI
                </h2>

                <p class="mt-2 text-emerald-100">
                    Platform Digital Kemitraan Pertanian Indonesia
                </p>

            </div>

            <div class="text-emerald-100 text-sm">
                © 2026 EXPORTANI. All rights reserved.
            </div>

        </div>

    </div>

</footer>

</body>
</html>
