<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                    {{ __('Produk saya') }}
                </h2>
                <p class="mt-1 text-sm text-stone-600">Daftar komoditas yang bisa dilihat eksportir.</p>
            </div>
            <a
                href="{{ route('petani.products.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-900/20 ring-1 ring-emerald-500/30 hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition"
            >
                Tambah produk
            </a>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-6">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-6 sm:p-8 shadow-sm shadow-stone-900/5">
                <div class="space-y-3">
                    @forelse ($products as $p)
                        <div class="rounded-xl border border-stone-200/80 bg-stone-50/40 p-5 transition hover:border-emerald-200 hover:bg-white">
                            <div class="font-display text-lg font-semibold text-stone-900">
                                {{ $p->nama_produk }}
                            </div>
                            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-stone-600">
                                <span>Jumlah <strong class="text-stone-800">{{ $p->jumlah }}</strong></span>
                                <span class="text-stone-300">·</span>
                                <span>Lokasi <strong class="text-stone-800">{{ $p->lokasi }}</strong></span>
                            </div>
                            <a href="{{ route('petani.products.edit', $p) }}" class="mt-3 inline-block text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                                Edit produk →
                            </a>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 px-6 py-14 text-center">
                            <p class="text-stone-600">Belum ada produk.</p>
                            <a href="{{ route('petani.products.create') }}" class="mt-3 inline-block text-sm font-semibold text-emerald-700 hover:text-emerald-800">Tambah produk pertama →</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
