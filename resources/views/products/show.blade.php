<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-exportani-border bg-white text-exportani-secondaryText hover:bg-exportani-background hover:text-exportani-primary transition shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">
                    Detail Produk
                </h2>
                <p class="mt-1 text-sm text-exportani-secondaryText">Tinjau penawaran komoditas ini dan ajukan kemitraan.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-exportani-mint/30 bg-exportani-mint/10 px-4 py-3 text-sm font-medium text-exportani-accent shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Image & Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Image -->
                <div class="rounded-2xl border border-exportani-border bg-white overflow-hidden shadow-sm">
                    @if($product->images->isNotEmpty())
                        <div class="grid grid-cols-1 gap-2 p-2 sm:grid-cols-2">
                            @foreach($product->images as $image)
                                <img src="{{ Storage::url($image->path) }}" alt="{{ $product->nama_produk }}" class="h-56 w-full rounded-xl object-cover">
                            @endforeach
                        </div>
                    @elseif($product->gambar)
                        <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}" class="h-full min-h-[280px] w-full object-cover">
                    @else
                        <div class="flex h-80 w-full flex-col items-center justify-center bg-gradient-to-br from-exportani-mint/10 via-exportani-primary/5 to-transparent text-exportani-secondaryText/50 gap-3 select-none border border-dashed border-exportani-border/40 m-2 rounded-xl">
                            <svg class="h-16 w-16 text-exportani-primary/25" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[9px] font-bold tracking-widest uppercase opacity-60">Exportani Premium Product</span>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="rounded-2xl border border-exportani-border bg-white p-6 sm:p-8 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <div class="mb-3 flex flex-wrap gap-2">
                                @if($product->category)
                                    <span class="inline-flex items-center rounded-full bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                                @if($product->is_recommended)
                                    <span class="inline-flex items-center rounded-full bg-amber-50 border border-amber-200/50 text-amber-800 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide">Rekomendasi</span>
                                @endif
                            </div>
                            <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-exportani-text leading-tight">{{ $product->nama_produk }}</h1>
                            <p class="mt-2 text-xl font-bold text-exportani-primary flex items-baseline gap-1">
                                <span>Rp{{ number_format($product->harga, 0, ',', '.') }}</span>
                                <span class="text-xs font-semibold text-exportani-secondaryText">/ {{ $product->satuan ?? 'kg' }}</span>
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('favorites.toggle', $product) }}" class="m-0">
                                @csrf
                                <button type="submit" class="flex h-12 w-12 items-center justify-center rounded-xl border border-exportani-border bg-white text-exportani-secondaryText shadow-sm hover:border-rose-200 hover:text-rose-500 hover:bg-rose-50 transition-colors focus:outline-none">
                                    <svg class="h-6 w-6" fill="{{ auth()->user()->favorites->contains($product->id) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 border-y border-exportani-border py-6">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-exportani-mint/10 text-exportani-accent border border-exportani-mint/20 rounded-xl">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-exportani-secondaryText font-bold uppercase tracking-wider">Stok / Kapasitas</p>
                                <p class="mt-0.5 text-base font-bold text-exportani-text">{{ number_format($product->jumlah, 0, ',', '.') }} {{ $product->satuan ?? 'kg' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-exportani-mint/10 text-exportani-accent border border-exportani-mint/20 rounded-xl">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-exportani-secondaryText font-bold uppercase tracking-wider">Lokasi Penawaran</p>
                                <p class="mt-0.5 text-base font-bold text-exportani-text">{{ $product->lokasi }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-base font-bold text-exportani-text uppercase tracking-wider">Deskripsi</h3>
                        <div class="mt-3 text-sm text-exportani-secondaryText leading-relaxed whitespace-pre-line">
                            {{ $product->deskripsi }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Action & Farmer Info -->
            <div class="space-y-6">
                <!-- Apply Card -->
                <div class="rounded-2xl border border-exportani-border bg-white p-6 shadow-sm sticky top-6">
                    <h3 class="font-bold text-exportani-text text-sm uppercase tracking-wider mb-2">Tertarik dengan penawaran ini?</h3>
                    <p class="text-xs text-exportani-secondaryText mb-6 font-medium">Kirimkan pengajuan kerja sama untuk memulai negosiasi dengan petani.</p>
                    
                    <form method="POST" action="{{ route('partnerships.apply', $product) }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-exportani-primary hover:bg-exportani-dark px-4 py-3 text-xs font-bold text-white shadow-sm transition flex items-center justify-center gap-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Ajukan Kerja Sama</span>
                        </button>
                    </form>

<<<<<<< Updated upstream
                    @if (Auth::user()->role === 'eksportir' && !Auth::user()->isPremium())
                        <!-- Locked Chat Button for Free Exporters -->
                        <a href="{{ route('premium.index') }}" class="mt-3 w-full rounded-xl border border-exportani-border bg-exportani-background text-exportani-secondaryText/70 px-4 py-3 text-xs font-bold shadow-sm hover:bg-white transition flex items-center justify-center gap-2 group relative">
                            <svg class="h-4 w-4 text-exportani-secondaryText" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span>Chat Petani</span>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 badge-premium text-[8px] px-1.5 py-0.5 rounded shadow-sm">Premium</span>
                        </a>
                    @else
                        <!-- Active Chat Form -->
                        <form method="POST" action="{{ route('chat.start') }}" class="mt-3 m-0">
                            @csrf
                            <input type="hidden" name="farmer_id" value="{{ $product->owner->id }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-full rounded-xl border border-exportani-border bg-white px-4 py-3 text-xs font-bold text-exportani-text hover:bg-exportani-background transition flex items-center justify-center gap-2">
                                <svg class="h-4 w-4 text-exportani-secondaryText" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Chat Petani
                            </button>
                        </form>
                    @endif
=======
                    <form method="POST" action="{{ route('chat.start') }}" class="mt-3">
                        @csrf
                        <input type="hidden" name="farmer_id" value="{{ $product->owner->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="w-full rounded-xl border border-stone-200 bg-white px-4 py-3.5 text-sm font-semibold text-stone-700 shadow-sm hover:bg-stone-50 transition-colors flex items-center justify-center gap-2">
                            <svg class="h-4 w-4 text-stone-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Chat Petani
                        </button>
                    </form>
>>>>>>> Stashed changes
                    
                    <p class="mt-4 text-center text-[10px] text-exportani-secondaryText leading-relaxed">
                        Anda akan dialihkan ke halaman monitoring status jika pengajuan berhasil.
                    </p>
                </div>

                <!-- Farmer Profile Card -->
                <div class="rounded-2xl border border-exportani-border bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-exportani-text text-sm uppercase tracking-wider mb-4">Informasi Petani</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-exportani-mint/15 text-lg font-bold text-exportani-accent border border-exportani-mint/20 uppercase">
                            {{ substr($product->owner->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-exportani-text text-sm">{{ $product->owner->name }}</p>
                            <p class="text-[10px] text-exportani-secondaryText">Bergabung sejak {{ $product->owner->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 text-xs text-exportani-secondaryText border-t border-exportani-border pt-4">
                        <li class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-exportani-secondaryText/60 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="font-medium text-exportani-text">{{ $product->owner->email }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-exportani-secondaryText/60 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="font-medium text-exportani-text">{{ $product->lokasi }}</span>
                        </li>
                        @if($product->owner->is_trusted_petani)
                        <li class="flex items-start gap-3 mt-2">
                            <span class="inline-flex items-center gap-1 rounded-full bg-exportani-mint/15 border border-exportani-mint/20 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider text-exportani-accent">
                                <svg class="h-3 w-3 text-exportani-primary" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                Petani Tepercaya
                            </span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
