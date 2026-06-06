<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Dashboard</h2>
            <p class="mt-1 text-sm text-stone-600">Ringkasan aktivitas akun kamu.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-6">
            <div class="rounded-2xl border border-exportani-mint/30 bg-gradient-to-r from-exportani-dark to-exportani-accent p-6 text-white shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <!-- Left: Profile and Greeting -->
                    <div>
                        <p class="text-sm text-white/90 font-medium">{{ auth()->user()->name }}</p>
                        <p class="mt-1.5 text-xl font-black tracking-tight leading-none">
                            @if($dashboardType === 'petani')
                                Dashboard Petani
                            @elseif($dashboardType === 'eksportir')
                                Dashboard Eksportir
                            @elseif($dashboardType === 'admin')
                                Dashboard Admin
                            @endif
                        </p>
                        <div class="mt-3 flex items-center gap-2 text-sm">
                            @if($dashboardType === 'petani')
                                @if(auth()->user()->is_trusted_petani)
                                    <span class="inline-flex rounded-full bg-white/20 px-2.5 py-0.5 text-xs font-semibold">Petani Tepercaya</span>
                                @else
                                    <span class="inline-flex rounded-full bg-white/10 px-2.5 py-0.5 text-xs font-medium opacity-80">Belum Tepercaya</span>
                                @endif
                            @endif
                            @if(!auth()->user()->isPremium())
                                <span class="inline-flex rounded-full bg-white/15 px-2.5 py-0.5 text-xs font-semibold opacity-85">
                                    Akun Free
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Info/Call-to-Action (Fills empty banner space) -->
                    <div class="hidden sm:block text-right border-l border-white/10 pl-6 py-1 max-w-[260px]">
                        @if(auth()->user()->isPremium())
                            <span class="text-[10px] font-extrabold text-[#F4D06F] uppercase tracking-widest block">Premium Member</span>
                            <p class="text-sm text-white mt-1.5 font-semibold leading-relaxed">Akses Fitur Tanpa Batas</p>
                            @if(auth()->user()->premium_expires_at)
                                <p class="text-xs text-white/80 mt-0.5">Aktif hingga <span class="font-semibold text-white/95">{{ auth()->user()->premium_expires_at->format('d M Y') }}</span></p>
                            @endif
                        @else
                            <span class="text-[9px] font-extrabold text-white/50 uppercase tracking-widest block">Free Tier</span>
                            <p class="text-xs text-white/90 mt-1.5 font-semibold leading-normal">Upgrade ke Premium untuk membuka semua limit ekspor.</p>
                            <a href="{{ route('premium.index') }}" class="inline-flex items-center gap-1 mt-2 text-[10px] font-extrabold text-[#F4D06F] hover:text-[#E6B85C] transition">
                                Upgrade Sekarang
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            @if($dashboardType === 'petani')
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Produk -->
                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wide">Total Produk</p>
                            <p class="mt-2 text-3xl font-black text-exportani-text">{{ $stats['total_produk'] }}</p>
                        </div>
                        <div class="p-3 bg-exportani-mint/15 rounded-xl text-exportani-accent">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <!-- Produk Aktif -->
                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wide">Produk Kategori Aktif</p>
                            <p class="mt-2 text-3xl font-black text-exportani-text">{{ $stats['produk_aktif'] }}</p>
                        </div>
                        <div class="p-3 bg-exportani-mint/15 rounded-xl text-exportani-accent">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Pengajuan Masuk -->
                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wide">Permintaan Kerja Sama</p>
                            <p class="mt-2 text-3xl font-black text-exportani-text">{{ $stats['incoming_total'] }}</p>
                        </div>
                        <div class="p-3 bg-exportani-mint/15 rounded-xl text-exportani-accent">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <!-- Accepted / Rejected -->
                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wide">Diterima / Ditolak</p>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="text-2xl font-black text-exportani-primary">{{ $stats['incoming_accepted'] }}</span>
                                <span class="text-stone-300 text-xs">/</span>
                                <span class="text-xl font-bold text-rose-500">{{ $stats['incoming_rejected'] }}</span>
                            </div>
                        </div>
                        <div class="p-3 bg-exportani-mint/15 rounded-xl text-exportani-accent">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-sm font-semibold text-exportani-text">Aktivitas Terbaru</p>
                            <ul class="mt-4 space-y-3 text-sm text-exportani-secondaryText">
                                <li class="flex justify-between border-b border-exportani-border pb-2">
                                    <span>Produk Terakhir:</span>
                                    <span class="font-semibold text-exportani-text">{{ $latest['produk']->nama_produk ?? '-' }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>Kerja Sama Terbaru:</span>
                                    <span class="font-semibold text-exportani-text">
                                        {{ $latest['kerja_sama']?->product?->nama_produk ?? '-' }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-sm font-semibold text-exportani-text">Akses Cepat</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('petani.products.create') }}" class="rounded-lg bg-exportani-primary px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-exportani-dark transition">Tambah Produk</a>
                                <a href="{{ route('requests.index') }}" class="rounded-lg border border-exportani-border px-3 py-2 text-xs font-semibold text-exportani-text hover:bg-exportani-background transition">Permintaan Masuk</a>
                                <a href="{{ route('partnerships.history') }}" class="rounded-lg border border-exportani-border px-3 py-2 text-xs font-semibold text-exportani-text hover:bg-exportani-background transition">Riwayat Kerja Sama</a>
                                <a href="{{ route('premium.index') }}" class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800 hover:bg-amber-100 transition">
                                    {{ auth()->user()->isPremium() ? 'Kelola Premium' : 'Upgrade Premium' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-exportani-border bg-white p-5 mt-4 shadow-sm">
                    <p class="text-sm font-semibold text-stone-850 mb-4">Statistik Aktivitas (6 Bulan Terakhir)</p>
                    <div class="relative h-64 w-full">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            @elseif($dashboardType === 'eksportir')
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Jumlah Pengajuan -->
                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wide">Jumlah Pengajuan</p>
                            <p class="mt-2 text-3xl font-black text-exportani-text">{{ $stats['total_pengajuan'] }}</p>
                        </div>
                        <div class="p-3 bg-exportani-mint/15 rounded-xl text-exportani-accent">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <!-- Kerja Sama Aktif -->
                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wide">Kerja Sama Aktif</p>
                            <p class="mt-2 text-3xl font-black text-exportani-text">{{ $stats['kerja_sama_aktif'] }}</p>
                        </div>
                        <div class="p-3 bg-exportani-mint/15 rounded-xl text-exportani-accent">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Limit Free User -->
                    <div class="rounded-2xl border-l-4 border-l-amber-300 border-y border-r border-exportani-border bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wide">Limit Free User</p>
                            <p class="mt-2 text-base font-bold text-exportani-text">
                                {{ is_null($account['remaining_limit'] ?? null) ? 'Akses Premium Unlimited' : 'Sisa '.$account['remaining_limit'].' Pengajuan' }}
                            </p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-sm font-semibold text-exportani-text">Aktivitas Terbaru</p>
                            <ul class="mt-4 space-y-3 text-sm text-exportani-secondaryText">
                                <li class="flex justify-between border-b border-exportani-border pb-2">
                                    <span>Pengajuan Terbaru:</span>
                                    <span class="font-semibold text-exportani-text">{{ $latest['pengajuan']?->product?->nama_produk ?? '-' }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>Favorit Terbaru:</span>
                                    <span class="font-semibold text-exportani-text">{{ $latest['favorit']?->nama_produk ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-sm font-semibold text-exportani-text">Akses Cepat</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('products.index') }}" class="rounded-lg bg-exportani-primary px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-exportani-dark transition">Cari Produk</a>
                                <a href="{{ route('premium.index') }}" class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800 hover:bg-amber-100 transition">
                                    {{ auth()->user()->isPremium() ? 'Kelola Premium' : 'Upgrade Premium' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-exportani-border bg-white p-5 mt-4 shadow-sm">
                    <p class="text-sm font-semibold text-exportani-text mb-4">Statistik Pengajuan (6 Bulan Terakhir)</p>
                    <div class="relative h-64 w-full">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            @elseif($dashboardType === 'admin')
                <!-- ADMIN DASHBOARD -->
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-exportani-text">Admin Dashboard</h2>
                    <p class="text-exportani-secondaryText text-sm">Ringkasan statistik sistem EXPORTANI</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-6 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-exportani-mint/15 text-exportani-accent">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-exportani-secondaryText">Total Pengguna</p>
                                <p class="text-2xl font-bold text-exportani-text">{{ $stats['total_user'] }}</p>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-4 text-xs text-exportani-secondaryText border-t border-exportani-border pt-3">
                            <span>Petani: <strong class="text-exportani-text">{{ $stats['total_farmer'] }}</strong></span>
                            <span>Eksportir: <strong class="text-exportani-text">{{ $stats['total_exporter'] }}</strong></span>
                        </div>
                    </div>

                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-6 shadow-sm flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-exportani-teal/15 text-exportani-teal">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-exportani-secondaryText">Total Produk</p>
                            <p class="text-2xl font-bold text-exportani-text">{{ $stats['total_produk'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-6 shadow-sm flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-exportani-primary/15 text-exportani-primary">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-exportani-secondaryText">Total Kerja Sama</p>
                            <p class="text-2xl font-bold text-exportani-text">{{ $stats['total_partnership'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-exportani-secondaryText">Kategori Produk</p>
                        <p class="text-2xl font-bold text-exportani-text mt-2">{{ $stats['total_categories'] }}</p>
                    </div>

                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-exportani-secondaryText">Produk Rekomendasi</p>
                        <p class="text-2xl font-bold text-exportani-text mt-2">{{ $stats['recommended_produk'] }}</p>
                    </div>

                    <div class="rounded-2xl border-l-4 border-l-exportani-mint border-y border-r border-exportani-border bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-exportani-secondaryText">Petani Tepercaya</p>
                        <p class="text-2xl font-bold text-exportani-text mt-2">{{ $stats['trusted_farmers'] }}</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm mt-4">
                    <p class="text-sm font-semibold text-exportani-text mb-4">Kelola Fitur</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="rounded-lg bg-exportani-primary px-3.5 py-2 text-xs font-semibold text-white hover:bg-exportani-dark transition">Kategori Produk</a>
                        <a href="{{ route('admin.recommendations.index') }}" class="rounded-lg border border-exportani-border px-3.5 py-2 text-xs font-semibold text-exportani-text hover:bg-exportani-background transition">Rekomendasi Produk</a>
                        <a href="{{ route('admin.trusted-farmers.index') }}" class="rounded-lg border border-exportani-border px-3.5 py-2 text-xs font-semibold text-exportani-text hover:bg-exportani-background transition">Petani Tepercaya</a>
                        <a href="{{ route('admin.premium-verifications.index') }}" class="rounded-lg border border-exportani-border px-3.5 py-2 text-xs font-semibold text-exportani-text hover:bg-exportani-background transition">Monitor Transaksi</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart.js Integration -->
    @if(isset($chartData))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('activityChart').getContext('2d');
            const data = @json($chartData);
            
            let datasets = [];
            
            if (data.products) {
                datasets.push({
                    label: 'Produk Ditambahkan',
                    data: data.products,
                    borderColor: '#2F7226', // exportani-primary
                    backgroundColor: 'rgba(47, 114, 38, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                });
            }
            
            if (data.partnerships) {
                datasets.push({
                    label: 'Kerja Sama Masuk',
                    data: data.partnerships,
                    borderColor: '#fbbf24', // amber-400
                    backgroundColor: 'rgba(251, 191, 36, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                });
            }

            if (data.pengajuan) {
                datasets.push({
                    label: 'Pengajuan Dibuat',
                    data: data.pengajuan,
                    borderColor: '#0284c7', // sky-600
                    backgroundColor: 'rgba(2, 132, 199, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                });
            }

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>
