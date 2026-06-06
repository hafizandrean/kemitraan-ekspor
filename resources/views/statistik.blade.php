<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik - EXPORTANI</title>

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

    <!-- CHART -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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

<body class="text-exportani-text antialiased font-sans bg-exportani-background">

<!-- NAVBAR -->
<nav class="bg-exportani-dark border-b border-exportani-primary/10">
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
                            Petani · Produk · Kerja sama
                        </p>
                    </div>
                </div>

                <!-- MENU -->
                <div class="hidden lg:flex items-center gap-2">
                    <a href="/" class="text-exportani-background/80 hover:text-white px-4 py-2.5 rounded-xl transition font-semibold text-sm">
                        Home
                    </a>
                    <a href="/about" class="text-exportani-background/80 hover:text-white px-4 py-2.5 rounded-xl transition font-semibold text-sm">
                        About
                    </a>
                    <a href="/statistik" class="bg-white/15 text-white px-4 py-2.5 rounded-xl font-semibold text-sm">
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

<!-- HEADER -->
<section class="bg-white border-b border-exportani-border">
    <div class="max-w-7xl mx-auto px-8 py-12">
        <h1 class="text-3xl font-black text-exportani-text font-display tracking-tight">
            Statistik Platform
        </h1>
        <p class="mt-1.5 text-sm text-exportani-secondaryText">
            Ringkasan aktivitas EXPORTANI pertanian.
        </p>
    </div>
</section>

<!-- CONTENT -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-8">
        <!-- TOP CARDS -->
        <div class="grid lg:grid-cols-4 gap-6">
            <!-- CARD 1 -->
            <div class="bg-white border-y border-r border-exportani-border border-l-4 border-l-exportani-mint rounded-2xl p-6 shadow-sm flex flex-col justify-between min-h-[170px]">
                <p class="text-exportani-secondaryText text-xs font-bold uppercase tracking-wider">
                    Total Produk
                </p>
                <h2 class="text-4xl font-extrabold text-exportani-text">
                    250
                </h2>
                <div class="mt-4 inline-flex items-center self-start gap-1 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-3 py-1 rounded-xl text-xs font-bold">
                    ↑ 12% bulan ini
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="bg-white border-y border-r border-exportani-border border-l-4 border-l-exportani-mint rounded-2xl p-6 shadow-sm flex flex-col justify-between min-h-[170px]">
                <p class="text-exportani-secondaryText text-xs font-bold uppercase tracking-wider">
                    Petani Aktif
                </p>
                <h2 class="text-4xl font-extrabold text-exportani-text">
                    120
                </h2>
                <div class="mt-4 inline-flex items-center self-start gap-1 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-3 py-1 rounded-xl text-xs font-bold">
                    Petani Tepercaya
                </div>
            </div>

            <!-- CARD 3 -->
            <div class="bg-white border-y border-r border-exportani-border border-l-4 border-l-exportani-mint rounded-2xl p-6 shadow-sm flex flex-col justify-between min-h-[170px]">
                <p class="text-exportani-secondaryText text-xs font-bold uppercase tracking-wider">
                    Eksportir
                </p>
                <h2 class="text-4xl font-extrabold text-exportani-text">
                    80
                </h2>
                <div class="mt-4 inline-flex items-center self-start gap-1 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-3 py-1 rounded-xl text-xs font-bold">
                    Premium User
                </div>
            </div>

            <!-- CARD 4 -->
            <div class="bg-white border-y border-r border-exportani-border border-l-4 border-l-exportani-mint rounded-2xl p-6 shadow-sm flex flex-col justify-between min-h-[170px]">
                <p class="text-exportani-secondaryText text-xs font-bold uppercase tracking-wider">
                    Kerja Sama
                </p>
                <h2 class="text-4xl font-extrabold text-exportani-text">
                    400
                </h2>
                <div class="mt-4 inline-flex items-center self-start gap-1 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-3 py-1 rounded-xl text-xs font-bold">
                    Partnership Active
                </div>
            </div>
        </div>

        <!-- CHART -->
        <div class="grid lg:grid-cols-2 gap-6 mt-8">
            <!-- LEFT -->
            <div class="bg-white border border-exportani-border rounded-2xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-exportani-text font-display">
                            Statistik Produk
                        </h2>
                        <p class="mt-1 text-xs text-exportani-secondaryText">
                            Kategori produk pertanian
                        </p>
                    </div>
                    <div class="bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-3 py-1 rounded-xl text-xs font-bold">
                        Updated
                    </div>
                </div>
                <div id="produkChart" class="mt-8"></div>
            </div>

            <!-- RIGHT -->
            <div class="bg-white border border-exportani-border rounded-2xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-exportani-text font-display">
                            Status Kerja Sama
                        </h2>
                        <p class="mt-1 text-xs text-exportani-secondaryText">
                            Aktivitas pengajuan kerja sama
                        </p>
                    </div>
                    <div class="bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-3 py-1 rounded-xl text-xs font-bold animate-pulse">
                        Live
                    </div>
                </div>
                <div id="kerjasamaChart" class="mt-8"></div>
            </div>
        </div>

        <!-- BOTTOM -->
        <div class="grid lg:grid-cols-3 gap-6 mt-8">
            <!-- CARD 1 -->
            <div class="rounded-2xl p-8 text-white relative overflow-hidden bg-gradient-to-br from-exportani-dark via-exportani-primary to-exportani-accent shadow-sm">
                <!-- NOISE PATTERN -->
                <div class="absolute inset-0 bg-noise-overlay opacity-[0.035] pointer-events-none"></div>
                <div class="relative z-10 space-y-4">
                    <p class="text-exportani-mint text-xs font-bold uppercase tracking-wider">
                        Platform Growth
                    </p>
                    <h2 class="text-5xl font-black">
                        85%
                    </h2>
                    <p class="text-sm text-exportani-background leading-relaxed">
                        Tingkat keberhasilan kerja sama antar pengguna platform.
                    </p>
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="bg-white border border-exportani-border rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="text-lg font-bold text-exportani-text font-display">
                    Aktivitas Terbaru
                </h2>
                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-exportani-border pb-3 last:border-0 last:pb-0">
                        <div>
                            <p class="font-bold text-exportani-text text-sm">
                                Produk Cabai
                            </p>
                            <p class="text-xs text-exportani-secondaryText">
                                Ditambahkan petani
                            </p>
                        </div>
                        <span class="text-xs text-exportani-secondaryText/70 font-medium">
                            2m ago
                        </span>
                    </div>

                    <div class="flex items-center justify-between border-b border-exportani-border pb-3 last:border-0 last:pb-0">
                        <div>
                            <p class="font-bold text-exportani-text text-sm">
                                Pengajuan Baru
                            </p>
                            <p class="text-xs text-exportani-secondaryText">
                                Kerja sama eksportir
                            </p>
                        </div>
                        <span class="text-xs text-exportani-secondaryText/70 font-medium">
                            10m ago
                        </span>
                    </div>
                </div>
            </div>

            <!-- CARD 3 -->
            <div class="bg-white border border-exportani-border rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="text-lg font-bold text-exportani-text font-display">
                    Insight Platform
                </h2>
                <div class="mt-6 space-y-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-exportani-secondaryText font-medium">
                                Petani Tepercaya
                            </span>
                            <span class="font-bold text-exportani-text">
                                70%
                            </span>
                        </div>
                        <div class="w-full h-2.5 bg-exportani-background rounded-full overflow-hidden">
                            <div class="h-full w-[70%] bg-exportani-primary rounded-full"></div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-exportani-secondaryText font-medium">
                                Eksportir Premium
                            </span>
                            <span class="font-bold text-exportani-text">
                                55%
                            </span>
                        </div>
                        <div class="w-full h-2.5 bg-exportani-background rounded-full overflow-hidden">
                            <div class="h-full w-[55%] bg-exportani-primary rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SCRIPT -->
<script>
    // BAR CHART
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
            categories: ['Sayur', 'Buah', 'Rempah', 'Beras', 'Jagung'],
            labels: {
                style: {
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                }
            }
        },
        colors: ['#2F7226'],
        plotOptions: {
            bar: {
                borderRadius: 6,
                columnWidth: '45%'
            }
        },
        dataLabels: {
            enabled: false
        },
        grid: {
            borderColor: '#E5E7EB'
        },
        tooltip: {
            style: {
                fontSize: '12px',
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#produkChart"), options);
    chart.render();

    // DONUT CHART
    var options2 = {
        chart: {
            type: 'donut',
            height: 320
        },
        series: [70, 20, 10],
        labels: ['Accepted', 'Pending', 'Rejected'],
        colors: ['#2F7226', '#74C690', '#005700'],
        legend: {
            position: 'bottom',
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            style: {
                fontSize: '12px',
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            }
        }
    };

    var chart2 = new ApexCharts(document.querySelector("#kerjasamaChart"), options2);
    chart2.render();
</script>

</body>
</html>
