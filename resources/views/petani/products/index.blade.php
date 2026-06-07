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

            @if ($products->isEmpty())
                <div class="rounded-2xl border border-dashed border-stone-300 bg-stone-50 px-6 py-14 text-center">
                    <p class="text-exportani-secondaryText">Belum ada produk.</p>
                    <a href="{{ route('petani.products.create') }}" class="mt-3 inline-block text-sm font-semibold text-exportani-accent hover:text-exportani-dark">Tambah produk pertama →</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $p)
                        <div class="group flex flex-col overflow-hidden rounded-2xl border border-exportani-border bg-white transition hover:-translate-y-1 hover:shadow-xl hover:shadow-exportani-primary/5">
                            <div class="relative block h-48 overflow-hidden bg-exportani-background">
                                @if($p->gambar)
                                    <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->nama_produk }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-exportani-mint/10 via-exportani-primary/5 to-transparent text-exportani-secondaryText/50 gap-2 select-none">
                                        <svg class="h-10 w-10 text-exportani-primary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-[9px] font-bold tracking-widest uppercase opacity-60">Exportani Product</span>
                                    </div>
                                @endif
                                
                                @if($p->category)
                                    <div class="absolute top-3 right-3 rounded-full bg-white/90 px-2.5 py-0.5 text-[9px] font-bold text-exportani-accent border border-exportani-border backdrop-blur-sm shadow-sm uppercase tracking-wide">
                                        {{ $p->category->name }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-1 flex-col p-5">
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-display text-lg font-bold text-exportani-text group-hover:text-exportani-primary truncate transition duration-150">
                                        {{ $p->nama_produk }}
                                    </h3>
                                    <p class="mt-2 text-xl font-bold text-exportani-primary">
                                        Rp{{ number_format($p->harga, 0, ',', '.') }}
                                    </p>
                                    <div class="mt-4 grid grid-cols-2 gap-y-2 text-xs text-exportani-secondaryText font-medium border-b border-exportani-border pb-4">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-exportani-secondaryText/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                            <span class="truncate">{{ number_format($p->jumlah, 0, ',', '.') }} {{ $p->satuan ?? 'kg' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-exportani-secondaryText/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span class="truncate">{{ $p->lokasi }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center justify-between gap-2">
                                    <a href="{{ route('petani.products.edit', $p) }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-exportani-primary text-exportani-primary hover:bg-exportani-primary hover:text-white px-3 py-2.5 text-xs font-bold transition shadow-sm">
                                        Edit Produk
                                    </a>
                                    <form method="POST" action="{{ route('petani.products.destroy', $p) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 px-3 py-2.5 text-xs font-bold transition">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
