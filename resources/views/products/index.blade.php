<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                {{ __('Cari produk') }}
            </h2>
            <p class="mt-1 text-sm text-stone-600">Temukan komoditas terbaik dari petani terpercaya untuk kebutuhan ekspor Anda.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar / Advanced Search -->
            <div class="w-full lg:w-1/4">
                <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-5 sm:p-6 shadow-sm shadow-stone-900/5 backdrop-blur-md sticky top-6">
                    <h3 class="font-semibold text-stone-900 mb-4">Filter Pencarian</h3>
                    
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                        <!-- Keyword -->
                        <div>
                            <x-input-label for="q" value="Kata Kunci" class="text-xs" />
                            <x-text-input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Mangga, Kopi..." class="mt-1 block w-full text-sm rounded-lg" />
                        </div>
                        
                        <!-- Kategori -->
                        <div>
                            <x-input-label for="category_id" value="Kategori" class="text-xs" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full text-sm border-stone-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $kat)
                                    <option value="{{ $kat->id }}" {{ request('category_id') == $kat->id ? 'selected' : '' }}>{{ $kat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Lokasi -->
                        <div>
                            <x-input-label for="location" value="Lokasi" class="text-xs" />
                            <x-text-input id="location" type="text" name="location" value="{{ request('location') }}" placeholder="Provinsi/Kota" class="mt-1 block w-full text-sm rounded-lg" />
                        </div>
                        
                        <!-- Harga Min -->
                        <div>
                            <x-input-label for="min_price" value="Harga Minimal (Rp)" class="text-xs" />
                            <x-text-input id="min_price" type="number" name="min_price" value="{{ request('min_price') }}" min="0" placeholder="0" class="mt-1 block w-full text-sm rounded-lg" />
                        </div>
                        
                        <!-- Harga Max -->
                        <div>
                            <x-input-label for="max_price" value="Harga Maksimal (Rp)" class="text-xs" />
                            <x-text-input id="max_price" type="number" name="max_price" value="{{ request('max_price') }}" min="0" placeholder="Tak terhingga" class="mt-1 block w-full text-sm rounded-lg" />
                        </div>

                        <!-- Urutkan -->
                        <div>
                            <x-input-label for="sort" value="Urutkan" class="text-xs" />
                            <select id="sort" name="sort" class="mt-1 block w-full text-sm border-stone-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                                <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                            </select>
                        </div>

                        <div class="pt-2">
                            <x-primary-button type="submit" class="w-full justify-center bg-emerald-600 hover:bg-emerald-700">Terapkan Filter</x-primary-button>
                            @if(request()->anyFilled(['q', 'category_id', 'location', 'min_price', 'max_price']) || request('sort') != 'terbaru')
                                <a href="{{ route('products.index') }}" class="mt-2 block text-center text-xs text-stone-500 hover:text-stone-700 underline">Reset Filter</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="w-full lg:w-3/4">
                <div class="mb-4 text-sm text-stone-600">
                    Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari total {{ $products->total() }} produk
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($products as $p)
                        <div class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white transition hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-900/5">
                            <a href="{{ route('products.show', $p) }}" class="relative block h-48 overflow-hidden bg-stone-100">
                                @if($p->gambar)
                                    <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->nama_produk }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-stone-400">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                @if($p->category)
                                    <div class="absolute top-3 right-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-emerald-800 backdrop-blur-sm shadow-sm">
                                        {{ $p->category->name }}
                                    </div>
                                @endif
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <a href="{{ route('products.show', $p) }}" class="min-w-0 flex-1">
                                    <h3 class="font-display text-lg font-bold text-stone-900 group-hover:text-emerald-700 truncate">
                                        {{ $p->nama_produk }}
                                    </h3>
                                    <p class="mt-1 text-xl font-bold text-emerald-600">
                                        Rp{{ number_format($p->harga, 0, ',', '.') }}
                                    </p>
                                    <div class="mt-3 grid grid-cols-2 gap-y-2 text-xs text-stone-600">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                            <span class="truncate">{{ number_format($p->jumlah, 0, ',', '.') }} kg</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span class="truncate">{{ $p->lokasi }}</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="mt-5 pt-4 border-t border-stone-100 flex items-center justify-between">
                                    <form method="POST" action="{{ route('favorites.toggle', $p) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-stone-400 hover:text-rose-500 transition-colors">
                                            <svg class="h-5 w-5" fill="{{ auth()->user()->favorites->contains($p->id) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <a href="{{ route('products.show', $p) }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                                        Lihat Detail <span aria-hidden="true" class="ml-1">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-stone-300 bg-white px-6 py-16 text-center shadow-sm">
                            <svg class="mx-auto h-12 w-12 text-stone-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-stone-900">Produk tidak ditemukan</h3>
                            <p class="mt-1 text-sm text-stone-500">Coba gunakan kata kunci atau filter lain yang lebih umum.</p>
                            @if(request()->anyFilled(['q', 'category_id', 'location', 'min_price', 'max_price']))
                                <div class="mt-6">
                                    <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                                        Reset Filter
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforelse
                </div>

                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

