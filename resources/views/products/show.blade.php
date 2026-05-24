<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-100 text-stone-500 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                    Detail Produk
                </h2>
                <p class="mt-1 text-sm text-stone-600">Tinjau penawaran komoditas ini dan ajukan kemitraan.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Image & Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Image -->
                <div class="rounded-2xl border border-stone-200/80 bg-white overflow-hidden shadow-sm shadow-stone-900/5">
                    @if($product->images->isNotEmpty())
                        <div class="grid grid-cols-1 gap-2 p-2 sm:grid-cols-2">
                            @foreach($product->images as $image)
                                <img src="{{ Storage::url($image->path) }}" alt="{{ $product->nama_produk }}" class="h-56 w-full rounded-xl object-cover">
                            @endforeach
                        </div>
                    @elseif($product->gambar)
                        <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}" class="h-full min-h-[280px] w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-stone-50 text-stone-400">
                            <svg class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="rounded-2xl border border-stone-200/80 bg-white p-6 sm:p-8 shadow-sm shadow-stone-900/5">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <div class="mb-3 flex flex-wrap gap-2">
                                @if($product->category)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                                @if($product->is_recommended)
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Rekomendasi</span>
                                @endif
                            </div>
                            <h1 class="font-display text-3xl font-bold text-stone-900">{{ $product->nama_produk }}</h1>
                            <p class="mt-2 text-2xl font-bold text-emerald-600">Rp{{ number_format($product->harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('favorites.toggle', $product) }}">
                                @csrf
                                <button type="submit" class="flex h-12 w-12 items-center justify-center rounded-xl border border-stone-200 bg-white text-stone-500 shadow-sm hover:border-rose-200 hover:text-rose-500 hover:bg-rose-50 transition-colors">
                                    <svg class="h-6 w-6" fill="{{ auth()->user()->favorites->contains($product->id) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4 border-y border-stone-100 py-6">
                        <div>
                            <p class="text-sm text-stone-500">Stok / Kapasitas</p>
                            <p class="mt-1 text-lg font-semibold text-stone-900">{{ number_format($product->jumlah, 0, ',', '.') }} {{ $product->satuan ?? 'kg' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-stone-500">Lokasi Penawaran</p>
                            <p class="mt-1 text-lg font-semibold text-stone-900">{{ $product->lokasi }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-stone-900">Deskripsi</h3>
                        <div class="mt-3 text-stone-600 leading-relaxed whitespace-pre-line">
                            {{ $product->deskripsi }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Action & Farmer Info -->
            <div class="space-y-6">
                <!-- Apply Card -->
                <div class="rounded-2xl border border-stone-200/80 bg-white p-6 shadow-sm shadow-stone-900/5 sticky top-6">
                    <h3 class="font-semibold text-stone-900 mb-2">Tertarik dengan penawaran ini?</h3>
                    <p class="text-sm text-stone-600 mb-6">Kirimkan pengajuan kerja sama untuk memulai negosiasi dengan petani.</p>
                    
                    <form method="POST" action="{{ route('partnerships.apply', $product) }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-colors">
                            Ajukan Kerja Sama
                        </button>
                    </form>
                    
                    <p class="mt-4 text-center text-xs text-stone-500">
                        Anda akan dialihkan ke halaman monitoring status jika pengajuan berhasil.
                    </p>
                </div>

                <!-- Farmer Profile Card -->
                <div class="rounded-2xl border border-stone-200/80 bg-white p-6 shadow-sm shadow-stone-900/5">
                    <h3 class="font-semibold text-stone-900 mb-4">Informasi Petani</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-xl font-bold text-emerald-800 uppercase">
                            {{ substr($product->owner->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-stone-900">{{ $product->owner->name }}</p>
                            <p class="text-xs text-stone-500">Bergabung sejak {{ $product->owner->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 text-sm text-stone-600 border-t border-stone-100 pt-4">
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-stone-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $product->owner->email }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-stone-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $product->lokasi }}</span>
                        </li>
                        @if($product->owner->is_trusted_farmer)
                        <li class="flex items-start gap-3 mt-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                Verified Farmer
                            </span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
