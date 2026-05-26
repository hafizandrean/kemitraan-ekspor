<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Dashboard</h2>
            <p class="mt-1 text-sm text-stone-600">Ringkasan aktivitas akun kamu.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-6">
            <div class="rounded-2xl border border-emerald-200/70 bg-gradient-to-r from-emerald-600 to-teal-700 p-6 text-white">
                <p class="text-sm text-emerald-100">Halo, {{ auth()->user()->name }}</p>
                <p class="mt-1 text-lg font-semibold">
                    @if($dashboardType === 'farmer')
                        Dashboard Petani
                    @elseif($dashboardType === 'exporter')
                        Dashboard Eksportir
                    @elseif($dashboardType === 'admin')
                        Dashboard Admin
                    @endif
                </p>
                <div class="mt-3 text-sm">
                    @if($dashboardType === 'farmer')
                        @if(auth()->user()->is_trusted_farmer)
                            <span class="inline-flex rounded-full bg-white/20 px-2.5 py-1 text-xs font-semibold">Trusted Farmer</span>
                        @else
                            <span class="inline-flex rounded-full bg-white/20 px-2.5 py-1 text-xs font-semibold">Belum trusted</span>
                        @endif
                    @else
                        <span class="inline-flex rounded-full bg-white/20 px-2.5 py-1 text-xs font-semibold">
                            {{ ($account['is_premium'] ?? false) ? 'Premium' : 'Free User' }}
                        </span>
                    @endif
                </div>
            </div>

            @if($dashboardType === 'farmer')
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border border-stone-200 bg-white p-5"><p class="text-sm text-stone-500">Total Produk</p><p class="mt-1 text-2xl font-semibold">{{ $stats['total_produk'] }}</p></div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5"><p class="text-sm text-stone-500">Produk Aktif</p><p class="mt-1 text-2xl font-semibold">{{ $stats['produk_aktif'] }}</p></div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5"><p class="text-sm text-stone-500">Pengajuan Masuk</p><p class="mt-1 text-2xl font-semibold">{{ $stats['incoming_total'] }}</p></div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5"><p class="text-sm text-stone-500">Accepted / Rejected</p><p class="mt-1 text-2xl font-semibold">{{ $stats['incoming_accepted'] }} / {{ $stats['incoming_rejected'] }}</p></div>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="rounded-xl border border-stone-200 bg-white p-5">
                        <p class="text-sm font-semibold text-stone-800">Aktivitas terbaru</p>
                        <ul class="mt-3 space-y-2 text-sm text-stone-600">
                            <li>Produk terakhir: <span class="font-medium text-stone-900">{{ $latest['produk']->nama_produk ?? '-' }}</span></li>
                            <li>Kerja sama terbaru:
                                <span class="font-medium text-stone-900">
                                    {{ $latest['kerja_sama']?->product?->nama_produk ?? '-' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5">
                        <p class="text-sm font-semibold text-stone-800">Shortcut</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ route('petani.products.create') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700">Tambah Produk</a>
                            <a href="{{ route('requests.index') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Permintaan Masuk</a>
                            <a href="{{ route('partnerships.history') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Riwayat Kerja Sama</a>
                            <a href="{{ route('profile.edit') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Edit Profil</a>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200 bg-white p-5 mt-4">
                    <p class="text-sm font-semibold text-stone-800 mb-4">Statistik Aktivitas (6 Bulan Terakhir)</p>
                    <div class="relative h-64 w-full">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            @elseif($dashboardType === 'exporter')
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-xl border border-stone-200 bg-white p-5"><p class="text-sm text-stone-500">Jumlah Pengajuan</p><p class="mt-1 text-2xl font-semibold">{{ $stats['total_pengajuan'] }}</p></div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5"><p class="text-sm text-stone-500">Kerja Sama Aktif</p><p class="mt-1 text-2xl font-semibold">{{ $stats['kerja_sama_aktif'] }}</p></div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5">
                        <p class="text-sm text-stone-500">Limit Free User</p>
                        <p class="mt-1 text-2xl font-semibold">
                            {{ is_null($account['remaining_limit'] ?? null) ? 'Unlimited' : 'Sisa '.$account['remaining_limit'].' hari ini' }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="rounded-xl border border-stone-200 bg-white p-5">
                        <p class="text-sm font-semibold text-stone-800">Aktivitas terbaru</p>
                        <ul class="mt-3 space-y-2 text-sm text-stone-600">
                            <li>Pengajuan terbaru: <span class="font-medium text-stone-900">{{ $latest['pengajuan']?->product?->nama_produk ?? '-' }}</span></li>
                            <li>Favorit terbaru: <span class="font-medium text-stone-900">{{ $latest['favorit']?->nama_produk ?? '-' }}</span></li>
                        </ul>
                    </div>
                    <div class="rounded-xl border border-stone-200 bg-white p-5">
                        <p class="text-sm font-semibold text-stone-800">Shortcut</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ route('products.index') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700">Cari Produk</a>
                            <a href="{{ route('favorites.index') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Favorit Produk</a>
                            <a href="{{ route('premium.upgrade') }}" class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-sm font-medium text-amber-800 hover:bg-amber-100">
                                {{ ($account['is_premium'] ?? false) ? 'Kelola Premium' : 'Upgrade Premium' }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200 bg-white p-5 mt-4">
                    <p class="text-sm font-semibold text-stone-800 mb-4">Statistik Pengajuan (6 Bulan Terakhir)</p>
                    <div class="relative h-64 w-full">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            @elseif($dashboardType === 'admin')
                <!-- ADMIN DASHBOARD -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-stone-800">Admin Dashboard</h2>
                    <p class="text-stone-500">Ringkasan statistik sistem EXPORTANI</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-stone-500">Total Pengguna</p>
                                <p class="text-2xl font-bold text-stone-800">{{ $stats['total_user'] }}</p>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-4 text-sm text-stone-500">
                            <span>Petani: <strong class="text-stone-800">{{ $stats['total_farmer'] }}</strong></span>
                            <span>Eksportir: <strong class="text-stone-800">{{ $stats['total_exporter'] }}</strong></span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-stone-500">Total Produk</p>
                                <p class="text-2xl font-bold text-stone-800">{{ $stats['total_produk'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-stone-500">Total Kerja Sama</p>
                                <p class="text-2xl font-bold text-stone-800">{{ $stats['total_partnership'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-stone-500">Kategori Produk</p>
                        <p class="text-2xl font-bold text-stone-800">{{ $stats['total_categories'] }}</p>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-stone-500">Produk Rekomendasi</p>
                        <p class="text-2xl font-bold text-stone-800">{{ $stats['recommended_produk'] }}</p>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-stone-500">Trusted Farmer</p>
                        <p class="text-2xl font-bold text-stone-800">{{ $stats['trusted_farmers'] }}</p>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200 bg-white p-5">
                    <p class="text-sm font-semibold text-stone-800 mb-3">Kelola Fitur</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700">Kategori Produk</a>
                        <a href="{{ route('admin.recommendations.index') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Rekomendasi Produk</a>
                        <a href="{{ route('admin.trusted-farmers.index') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Trusted Farmer</a>
                        <a href="{{ route('admin.premium-verifications.index') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Verifikasi Premium</a>
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

