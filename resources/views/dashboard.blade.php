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
                    @if($dashboardType === 'petani')
                        Dashboard Petani
                    @else
                        Dashboard Eksportir
                    @endif
                </p>
                <div class="mt-3 text-sm">
                    @if($dashboardType === 'petani')
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

            @if($dashboardType === 'petani')
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
                            <a href="{{ route('petani.products.create') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white">Tambah Produk</a>
                            <a href="{{ route('requests.index') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700">Lihat Kerja Sama</a>
                            <a href="{{ route('profile.edit') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700">Edit Profil</a>
                        </div>
                    </div>
                </div>
            @else
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
                            <a href="{{ route('products.index') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white">Cari Produk</a>
                            <a href="{{ route('favorites.index') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700">Favorit Produk</a>
                            @if(!($account['is_premium'] ?? false))
                                <span class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-sm font-medium text-amber-800">Upgrade Premium (coming soon)</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

