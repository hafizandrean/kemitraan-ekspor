<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Dashboard</h2>
            <p class="mt-1 text-sm text-stone-600">Ringkasan aktivitas akun kamu.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-6">
            <div class="rounded-2xl border border-emerald-250 bg-gradient-to-r from-emerald-600 to-teal-700 p-6 text-white shadow-sm">
                <div class="flex items-center gap-3">
                    <p class="text-sm text-emerald-100">Halo, {{ auth()->user()->name }}</p>
                    @if(auth()->user()->isPremium())
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-400 px-2.5 py-0.5 text-[10px] font-bold text-stone-900 shadow-sm uppercase tracking-wide">
                            <svg class="h-2.5 w-2.5 text-stone-900 fill-current shrink-0" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Premium
                        </span>
                    @endif
                </div>
                <p class="mt-1 text-lg font-semibold">
                    @if($dashboardType === 'petani')
                        Dashboard Petani
                    @elseif($dashboardType === 'eksportir')
                        Dashboard Eksportir
                    @elseif($dashboardType === 'admin')
                        Dashboard Admin
                    @endif
                </p>
                <div class="mt-3 flex gap-2 text-sm">
                    @if($dashboardType === 'petani')
                        @if(auth()->user()->is_trusted_petani)
                            <span class="inline-flex rounded-full bg-white/20 px-2.5 py-1 text-xs font-medium">Petani Tepercaya</span>
                        @else
                            <span class="inline-flex rounded-full bg-white/10 px-2.5 py-1 text-xs font-medium opacity-80">Belum Tepercaya</span>
                        @endif
                    @endif
                    <span class="inline-flex rounded-full bg-white/20 px-2.5 py-1 text-xs font-medium">
                        {{ auth()->user()->isPremium() ? 'Premium' : 'Akun Free' }}
                    </span>
                </div>
            </div>

            @if($dashboardType === 'petani')
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Produk -->
                    <div class="rounded-xl border border-stone-200/80 bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-stone-500 uppercase tracking-wide">Total Produk</p>
                            <p class="mt-2 text-3xl font-black text-stone-900">{{ $stats['total_produk'] }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <!-- Produk Aktif -->
                    <div class="rounded-xl border border-stone-200/80 bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-stone-500 uppercase tracking-wide">Produk Kategori Aktif</p>
                            <p class="mt-2 text-3xl font-black text-stone-900">{{ $stats['produk_aktif'] }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Pengajuan Masuk -->
                    <div class="rounded-xl border border-stone-200/80 bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-stone-500 uppercase tracking-wide">Permintaan Kerja Sama</p>
                            <p class="mt-2 text-3xl font-black text-stone-900">{{ $stats['incoming_total'] }}</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <!-- Accepted / Rejected -->
                    <div class="rounded-xl border border-stone-200/80 bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-stone-500 uppercase tracking-wide">Diterima / Ditolak</p>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="text-2xl font-black text-emerald-600">{{ $stats['incoming_accepted'] }}</span>
                                <span class="text-stone-300 text-xs">/</span>
                                <span class="text-xl font-bold text-rose-500">{{ $stats['incoming_rejected'] }}</span>
                            </div>
                        </div>
                        <div class="p-3 bg-stone-50 rounded-xl text-stone-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-sm font-semibold text-stone-850">Aktivitas Terbaru</p>
                            <ul class="mt-4 space-y-3 text-sm text-stone-600">
                                <li class="flex justify-between border-b border-stone-100 pb-2">
                                    <span>Produk Terakhir:</span>
                                    <span class="font-semibold text-stone-900">{{ $latest['produk']->nama_produk ?? '-' }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>Kerja Sama Terbaru:</span>
                                    <span class="font-semibold text-stone-900">
                                        {{ $latest['kerja_sama']?->product?->nama_produk ?? '-' }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-sm font-semibold text-stone-850">Akses Cepat</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('petani.products.create') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-emerald-700 transition">Tambah Produk</a>
                                <a href="{{ route('requests.index') }}" class="rounded-lg border border-stone-350 px-3 py-2 text-xs font-semibold text-stone-750 hover:bg-stone-50 transition">Permintaan Masuk</a>
                                <a href="{{ route('partnerships.history') }}" class="rounded-lg border border-stone-350 px-3 py-2 text-xs font-semibold text-stone-750 hover:bg-stone-50 transition">Riwayat Kerja Sama</a>
                                <a href="{{ route('premium.index') }}" class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800 hover:bg-amber-100 transition">
                                    {{ auth()->user()->isPremium() ? 'Kelola Premium' : 'Upgrade Premium' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200 bg-white p-5 mt-4 shadow-sm">
                    <p class="text-sm font-semibold text-stone-850 mb-4">Statistik Aktivitas (6 Bulan Terakhir)</p>
                    <div class="relative h-64 w-full">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            @elseif($dashboardType === 'eksportir')
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Jumlah Pengajuan -->
                    <div class="rounded-xl border border-stone-200/80 bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-stone-500 uppercase tracking-wide">Jumlah Pengajuan</p>
                            <p class="mt-2 text-3xl font-black text-stone-900">{{ $stats['total_pengajuan'] }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <!-- Kerja Sama Aktif -->
                    <div class="rounded-xl border border-stone-200/80 bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-stone-500 uppercase tracking-wide">Kerja Sama Aktif</p>
                            <p class="mt-2 text-3xl font-black text-stone-900">{{ $stats['kerja_sama_aktif'] }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Limit Free User -->
                    <div class="rounded-xl border border-stone-200/80 bg-white p-5 shadow-sm flex items-center justify-between hover:shadow-md transition duration-200">
                        <div>
                            <p class="text-xs font-semibold text-stone-500 uppercase tracking-wide">Limit Free User</p>
                            <p class="mt-2 text-base font-bold text-stone-900">
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
                    <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-sm font-semibold text-stone-850">Aktivitas Terbaru</p>
                            <ul class="mt-4 space-y-3 text-sm text-stone-600">
                                <li class="flex justify-between border-b border-stone-100 pb-2">
                                    <span>Pengajuan Terbaru:</span>
                                    <span class="font-semibold text-stone-900">{{ $latest['pengajuan']?->product?->nama_produk ?? '-' }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>Favorit Terbaru:</span>
                                    <span class="font-semibold text-stone-900">{{ $latest['favorit']?->nama_produk ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-sm font-semibold text-stone-850">Akses Cepat</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('products.index') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-emerald-700 transition">Cari Produk</a>
                                <a href="{{ route('premium.index') }}" class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800 hover:bg-amber-100 transition">
                                    {{ auth()->user()->isPremium() ? 'Kelola Premium' : 'Upgrade Premium' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200 bg-white p-5 mt-4 shadow-sm">
                    <p class="text-sm font-semibold text-stone-850 mb-4">Statistik Pengajuan (6 Bulan Terakhir)</p>
                    <div class="relative h-64 w-full">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            @elseif($dashboardType === 'admin')
                <!-- ADMIN DASHBOARD -->
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-stone-800">Admin Dashboard</h2>
                    <p class="text-stone-500 text-sm">Ringkasan statistik sistem EXPORTANI</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-stone-500">Total Pengguna</p>
                                <p class="text-2xl font-bold text-stone-800">{{ $stats['total_user'] }}</p>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-4 text-xs text-stone-500 border-t border-stone-100 pt-3">
                            <span>Petani: <strong class="text-stone-800">{{ $stats['total_farmer'] }}</strong></span>
                            <span>Eksportir: <strong class="text-stone-800">{{ $stats['total_exporter'] }}</strong></span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-stone-500">Total Produk</p>
                            <p class="text-2xl font-bold text-stone-800">{{ $stats['total_produk'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-stone-500">Total Kerja Sama</p>
                            <p class="text-2xl font-bold text-stone-800">{{ $stats['total_partnership'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-stone-500">Kategori Produk</p>
                        <p class="text-2xl font-bold text-stone-800 mt-2">{{ $stats['total_categories'] }}</p>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-stone-500">Produk Rekomendasi</p>
                        <p class="text-2xl font-bold text-stone-800 mt-2">{{ $stats['recommended_produk'] }}</p>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-stone-500">Petani Tepercaya</p>
                        <p class="text-2xl font-bold text-stone-800 mt-2">{{ $stats['trusted_farmers'] }}</p>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm mt-4">
                    <p class="text-sm font-semibold text-stone-800 mb-4">Kelola Fitur</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="rounded-lg bg-emerald-600 px-3.5 py-2 text-xs font-semibold text-white hover:bg-emerald-700 transition">Kategori Produk</a>
                        <a href="{{ route('admin.recommendations.index') }}" class="rounded-lg border border-stone-300 px-3.5 py-2 text-xs font-semibold text-stone-750 hover:bg-stone-50 transition">Rekomendasi Produk</a>
                        <a href="{{ route('admin.trusted-farmers.index') }}" class="rounded-lg border border-stone-300 px-3.5 py-2 text-xs font-semibold text-stone-750 hover:bg-stone-50 transition">Petani Tepercaya</a>
                        <a href="{{ route('admin.premium-verifications.index') }}" class="rounded-lg border border-stone-300 px-3.5 py-2 text-xs font-semibold text-stone-750 hover:bg-stone-50 transition">Monitor Transaksi</a>
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
                    borderColor: '#059669', // emerald-600
                    backgroundColor: 'rgba(5, 150, 105, 0.1)',
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
