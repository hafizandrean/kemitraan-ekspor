@props(['product', 'showFavorite' => true])

<div class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white transition hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-900/5">
    <a href="{{ route('products.show', $product) }}" class="relative block h-48 overflow-hidden bg-stone-100">
        @if($product->gambar)
            <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-stone-400">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif
        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
            @if($product->is_recommended)
                <span class="rounded-full bg-amber-400 px-2.5 py-1 text-xs font-semibold text-amber-950 shadow-sm">Rekomendasi</span>
            @endif
            @if($product->owner?->is_trusted_farmer)
                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-600 px-2.5 py-1 text-xs font-semibold text-white shadow-sm">
                    <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    Trusted
                </span>
            @endif
        </div>
        @if($product->category)
            <div class="absolute top-3 right-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-emerald-800 backdrop-blur-sm shadow-sm">
                {{ $product->category->name }}
            </div>
        @endif
    </a>
    <div class="flex flex-1 flex-col p-5">
        <a href="{{ route('products.show', $product) }}" class="min-w-0 flex-1">
            <h3 class="font-display text-lg font-bold text-stone-900 group-hover:text-emerald-700 truncate">
                {{ $product->nama_produk }}
            </h3>
            <p class="mt-0.5 text-xs text-stone-500">{{ $product->owner?->name ?? 'Petani' }}</p>
            <p class="mt-1 text-xl font-bold text-emerald-600">
                Rp{{ number_format($product->harga, 0, ',', '.') }}
            </p>
            <div class="mt-3 grid grid-cols-2 gap-y-2 text-xs text-stone-600">
                <div class="flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span class="truncate">{{ number_format($product->jumlah, 0, ',', '.') }} {{ $product->satuan ?? 'kg' }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="truncate">{{ $product->lokasi }}</span>
                </div>
            </div>
        </a>
        @if($showFavorite && auth()->check())
            <div class="mt-5 pt-4 border-t border-stone-100 flex items-center justify-between">
                <form method="POST" action="{{ route('favorites.toggle', $product) }}" class="inline">
                    @csrf
                    <button type="submit" class="text-stone-400 hover:text-rose-500 transition-colors">
                        <svg class="h-5 w-5" fill="{{ auth()->user()->favorites->contains($product->id) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>
                <a href="{{ route('products.show', $product) }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                    Lihat Detail <span aria-hidden="true" class="ml-1">&rarr;</span>
                </a>
            </div>
        @endif
    </div>
</div>
