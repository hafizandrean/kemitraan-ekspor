<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">
                    {{ __('Produk Saya') }}
                </h2>
                <p class="mt-1 text-sm text-exportani-secondaryText">Daftar komoditas yang bisa dilihat eksportir.</p>
            </div>
            <a
                href="{{ route('petani.products.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-exportani-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-exportani-dark/10 hover:bg-exportani-dark focus:outline-none focus:ring-2 focus:ring-exportani-primary focus:ring-offset-2 transition"
            >
                Tambah produk
            </a>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-6">
            @if (session('success'))
                <div class="rounded-xl border border-exportani-mint/40 bg-exportani-mint/5 px-4 py-3 text-sm font-medium text-exportani-accent">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-2xl border border-exportani-border bg-white p-6 sm:p-8 shadow-sm">
                <div class="space-y-3">
                    @forelse ($products as $p)
                        <div class="rounded-2xl border border-exportani-border bg-exportani-background/30 p-5 transition hover:border-exportani-mint hover:bg-white hover:shadow-sm">
                            <div class="font-display text-lg font-semibold text-exportani-text">
                                {{ $p->nama_produk }}
                            </div>
                            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-exportani-secondaryText">
                                <span>Jumlah <strong class="text-exportani-text">{{ $p->jumlah }}</strong></span>
                                <span class="text-stone-300">·</span>
                                <span>Lokasi <strong class="text-exportani-text">{{ $p->lokasi }}</strong></span>
                            </div>
                            <a href="{{ route('petani.products.edit', $p) }}" class="mt-3 inline-block text-sm font-semibold text-exportani-accent hover:text-exportani-dark">
                                Edit produk →
                            </a>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-stone-300 bg-stone-50 px-6 py-14 text-center">
                            <p class="text-exportani-secondaryText">Belum ada produk.</p>
                            <a href="{{ route('petani.products.create') }}" class="mt-3 inline-block text-sm font-semibold text-exportani-accent hover:text-exportani-dark">Tambah produk pertama →</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
