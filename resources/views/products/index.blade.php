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

                        <div class="space-y-2 pt-1">
                            <label class="flex items-center gap-2 text-sm text-stone-700">
                                <input type="checkbox" name="trusted_only" value="1" {{ $trusted_only ? 'checked' : '' }} class="rounded border-stone-300 text-emerald-600 focus:ring-emerald-500">
                                Hanya Petani Tepercaya
                            </label>
                            <label class="flex items-center gap-2 text-sm text-stone-700">
                                <input type="checkbox" name="recommended_only" value="1" {{ $recommended_only ? 'checked' : '' }} class="rounded border-stone-300 text-amber-500 focus:ring-amber-500">
                                Hanya Rekomendasi
                            </label>
                        </div>

                        <div class="pt-2">
                            <x-primary-button type="submit" class="w-full justify-center bg-emerald-600 hover:bg-emerald-700">Terapkan Filter</x-primary-button>
                            @if(request()->anyFilled(['q', 'category_id', 'location', 'min_price', 'max_price', 'trusted_only', 'recommended_only']) || request('sort') != 'terbaru')
                                <a href="{{ route('products.index') }}" class="mt-2 block text-center text-xs text-stone-500 hover:text-stone-700 underline">Reset Filter</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="w-full lg:w-3/4 space-y-10">
                @if($recommendedProducts->isNotEmpty() && !request()->boolean('recommended_only') && !request()->anyFilled(['q', 'category_id', 'location', 'min_price', 'max_price', 'trusted_only']))
                    <div>
                        <h3 class="font-display text-xl font-semibold text-stone-900 mb-4">Rekomendasi untuk Anda</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($recommendedProducts as $p)
                                <x-product-card :product="$p" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                <div class="mb-4 text-sm text-stone-600">
                    Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari total {{ $products->total() }} produk
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($products as $p)
                        <x-product-card :product="$p" />
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
    </div>
</x-app-layout>

