<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | EXPORTANI</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F4F6F5; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-noise-overlay {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 250 250' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full bg-white rounded-2xl shadow-sm border border-exportani-border overflow-hidden text-center">
        <div class="relative bg-gradient-to-r from-[#005700] to-[#1F6F63] h-32 flex items-center justify-center overflow-hidden">
            <!-- NOISE PATTERN -->
            <div class="absolute inset-0 bg-noise-overlay opacity-[0.035] pointer-events-none"></div>
            <h1 class="relative z-10 text-white text-5xl font-black font-display opacity-50">500</h1>
        </div>
        <div class="p-10">
            <h2 class="text-2xl font-bold text-stone-900">Terjadi Kesalahan Server</h2>
            <p class="mt-4 text-stone-500 leading-relaxed">
                Maaf, saat ini sistem kami sedang mengalami gangguan internal. Silakan coba kembali dalam beberapa menit.
            </p>
            <div class="mt-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-[#2F7226] hover:bg-[#005700] transition text-white px-6 py-3 rounded-xl font-semibold">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Muat Ulang Halaman
                </a>
            </div>
        </div>
    </div>
</body>
</html>
