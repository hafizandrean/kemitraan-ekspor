<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Statistik - EXPORTANI</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CHART -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
<nav class="pattern-bg border-b border-emerald-800">

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
                            Petani · Produk · Kerja sama
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
                       class="text-emerald-100 hover:text-white px-5 py-3 rounded-xl transition">

                        About

                    </a>

                    <a href="/statistik"
                       class="bg-white/10 text-white px-5 py-3 rounded-xl font-semibold">

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

<!-- HEADER -->
<section class="bg-white border-b border-gray-200">

    <div class="max-w-7xl mx-auto px-8 py-12">

        <h1 class="heading-serif text-5xl font-black text-gray-900">
            Statistik Platform
        </h1>

        <p class="mt-4 text-lg text-gray-500">
            Ringkasan aktivitas EXPORTANI pertanian.
        </p>

    </div>

</section>

<!-- CONTENT -->
<section class="py-12">

    <div class="max-w-7xl mx-auto px-8">

        <!-- TOP CARDS -->
        <div class="grid lg:grid-cols-4 gap-6">

            <!-- CARD -->
            <div class="bg-white border border-gray-100 rounded-3xl p-8">

                <p class="text-gray-500 text-sm">
                    Total Produk
                </p>

                <h2 class="mt-4 text-5xl font-bold text-gray-900">
                    250
                </h2>

                <div class="mt-5 inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium">

                    ↑ 12% bulan ini

                </div>

            </div>

            <!-- CARD -->
            <div class="bg-white border border-gray-100 rounded-3xl p-8">

                <p class="text-gray-500 text-sm">
                    Petani Aktif
                </p>

                <h2 class="mt-4 text-5xl font-bold text-gray-900">
                    120
                </h2>

                <div class="mt-5 inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium">

                    Trusted Farmer

                </div>

            </div>

            <!-- CARD -->
            <div class="bg-white border border-gray-100 rounded-3xl p-8">

                <p class="text-gray-500 text-sm">
                    Eksportir
                </p>

                <h2 class="mt-4 text-5xl font-bold text-gray-900">
                    80
                </h2>

                <div class="mt-5 inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium">

                    Premium User

                </div>

            </div>

            <!-- CARD -->
            <div class="bg-white border border-gray-100 rounded-3xl p-8">

                <p class="text-gray-500 text-sm">
                    Kerja Sama
                </p>

                <h2 class="mt-4 text-5xl font-bold text-gray-900">
                    400
                </h2>

                <div class="mt-5 inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium">

                    Partnership Active

                </div>

            </div>

        </div>

        <!-- CHART -->
        <div class="grid lg:grid-cols-2 gap-6 mt-8">

            <!-- LEFT -->
            <div class="bg-white border border-gray-100 rounded-3xl p-8">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Statistik Produk
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Kategori produk pertanian
                        </p>

                    </div>

                    <div class="bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium">

                        Updated

                    </div>

                </div>

                <div id="produkChart" class="mt-8"></div>

            </div>

            <!-- RIGHT -->
            <div class="bg-white border border-gray-100 rounded-3xl p-8">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Status Kerja Sama
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Aktivitas pengajuan kerja sama
                        </p>

                    </div>

                    <div class="bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium">

                        Live

                    </div>

                </div>

                <div id="kerjasamaChart" class="mt-8"></div>

            </div>

        </div>

        <!-- BOTTOM -->
        <div class="grid lg:grid-cols-3 gap-6 mt-8">

            <!-- CARD -->
            <div class="pattern-bg rounded-3xl p-8 text-white">

                <p class="text-emerald-100 text-sm">
                    Platform Growth
                </p>

                <h2 class="mt-4 text-6xl font-black">
                    85%
                </h2>

                <p class="mt-4 text-emerald-100 leading-relaxed">

                    Tingkat keberhasilan kerja sama antar pengguna platform.

                </p>

            </div>

            <!-- CARD -->
            <div class="bg-white border border-gray-100 rounded-3xl p-8">

                <h2 class="text-2xl font-bold text-gray-900">
                    Aktivitas Terbaru
                </h2>

                <div class="mt-8 space-y-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="font-semibold text-gray-800">
                                Produk Cabai
                            </p>

                            <p class="text-sm text-gray-500">
                                Ditambahkan petani
                            </p>

                        </div>

                        <span class="text-sm text-gray-400">
                            2m ago
                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="font-semibold text-gray-800">
                                Pengajuan Baru
                            </p>

                            <p class="text-sm text-gray-500">
                                Kerja sama eksportir
                            </p>

                        </div>

                        <span class="text-sm text-gray-400">
                            10m ago
                        </span>

                    </div>

                </div>

            </div>

            <!-- CARD -->
            <div class="bg-white border border-gray-100 rounded-3xl p-8">

                <h2 class="text-2xl font-bold text-gray-900">
                    Insight Platform
                </h2>

                <div class="mt-8 space-y-6">

                    <div>

                        <div class="flex justify-between mb-2">

                            <span class="text-gray-600">
                                Trusted Farmer
                            </span>

                            <span class="font-semibold">
                                70%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">

                            <div class="h-full w-[70%] bg-emerald-600 rounded-full"></div>

                        </div>

                    </div>

                    <div>

                        <div class="flex justify-between mb-2">

                            <span class="text-gray-600">
                                Premium Exporter
                            </span>

                            <span class="font-semibold">
                                55%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">

                            <div class="h-full w-[55%] bg-emerald-600 rounded-full"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- SCRIPT -->
<script>

    // BAR
    var options = {

        chart: {
            type: 'bar',
            height: 320,
            toolbar: {
                show: false
            }
        },

        series: [{
            name: 'Produk',
            data: [44, 55, 41, 67, 22]
        }],

        xaxis: {
            categories: ['Sayur', 'Buah', 'Rempah', 'Beras', 'Jagung']
        },

        colors: ['#059669'],

        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '50%'
            }
        },

        dataLabels: {
            enabled: false
        },

        grid: {
            borderColor: '#f1f5f9'
        }

    };

    var chart = new ApexCharts(document.querySelector("#produkChart"), options);

    chart.render();


    // DONUT
    var options2 = {

        chart: {
            type: 'donut',
            height: 320
        },

        series: [70, 20, 10],

        labels: ['Accepted', 'Pending', 'Rejected'],

        colors:['#059669','#10b981','#064e3b'],

        legend: {
            position: 'bottom'
        },

        dataLabels: {
            enabled: false
        }

    };

    var chart2 = new ApexCharts(document.querySelector("#kerjasamaChart"), options2);

    chart2.render();

</script>

</body>
</html>
