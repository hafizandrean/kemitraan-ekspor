<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | Kemitraan Ekspor</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f5f5f4; }
        .heading-serif { font-family: 'Merriweather', serif; }
        .pattern-bg {
            background-color: #064e3b;
            background-image:
            linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 32px 32px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full bg-white rounded-3xl shadow-sm border border-stone-200 overflow-hidden text-center">
        <div class="pattern-bg h-32 flex items-center justify-center">
            <h1 class="text-white text-5xl font-black heading-serif opacity-50">500</h1>
        </div>
        <div class="p-10">
            <h2 class="text-2xl font-bold text-stone-900">Terjadi Kesalahan Server</h2>
            <p class="mt-4 text-stone-500 leading-relaxed">
                Maaf, saat ini sistem kami sedang mengalami gangguan internal. Silakan coba kembali dalam beberapa menit.
            </p>
            <div class="mt-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 transition text-white px-6 py-3 rounded-xl font-semibold">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Muat Ulang Halaman
                </a>
            </div>
        </div>
    </div>
</body>
</html>
