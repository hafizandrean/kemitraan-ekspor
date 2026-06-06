<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">
                {{ __('Cari Produk') }}
            </h2>
            <p class="mt-1 text-sm text-exportani-secondaryText">Temukan komoditas terbaik dari petani terpercaya untuk kebutuhan ekspor Anda.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-exportani-mint/30 bg-exportani-mint/10 px-4 py-3 text-sm font-medium text-exportani-accent shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar / Advanced Search -->
            <div class="w-full lg:w-1/4">
                <div class="rounded-2xl border border-exportani-border bg-white p-5 sm:p-6 shadow-sm sticky top-6">
                    <h3 class="font-semibold text-exportani-text mb-4">Filter Pencarian</h3>
                    
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                        <!-- Keyword -->
                        <div>
                            <x-input-label for="q" value="Kata Kunci" class="text-xs" />
                            <x-text-input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Mangga, Kopi..." class="mt-1 block w-full text-sm rounded-lg" />
                        </div>
                        
                        <!-- Kategori -->
                        <div>
                            <x-input-label for="category_id" value="Kategori" class="text-xs" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full text-sm border-exportani-border bg-white text-exportani-text focus:border-exportani-primary focus:ring-exportani-primary rounded-lg shadow-sm">
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
                            <select id="sort" name="sort" class="mt-1 block w-full text-sm border-exportani-border bg-white text-exportani-text focus:border-exportani-primary focus:ring-exportani-primary rounded-lg shadow-sm">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                                <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                            </select>
                        </div>

                        <div class="space-y-2 pt-1 font-medium">
                            <label class="flex items-center gap-2 text-xs text-exportani-text">
                                <input type="checkbox" name="trusted_only" value="1" {{ $trusted_only ? 'checked' : '' }} class="rounded border-exportani-border text-exportani-primary focus:ring-exportani-primary">
                                Hanya Petani Tepercaya
                            </label>
                            <label class="flex items-center gap-2 text-xs text-exportani-text">
                                <input type="checkbox" name="recommended_only" value="1" {{ $recommended_only ? 'checked' : '' }} class="rounded border-exportani-border text-amber-600 focus:ring-amber-500">
                                Hanya Rekomendasi
                            </label>
                        </div>

                        <div class="pt-2">
                            <x-primary-button type="submit" class="w-full justify-center">Terapkan Filter</x-primary-button>
                            @if(request()->anyFilled(['q', 'category_id', 'location', 'min_price', 'max_price', 'trusted_only', 'recommended_only']) || request('sort') != 'terbaru')
                                <a href="{{ route('products.index') }}" class="mt-3 block text-center text-xs text-exportani-secondaryText hover:text-exportani-primary font-bold transition">Reset Filter</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="w-full lg:w-3/4 space-y-8">
                @if($recommendedProducts->isNotEmpty() && !request()->boolean('recommended_only') && !request()->anyFilled(['q', 'category_id', 'location', 'min_price', 'max_price', 'trusted_only']))
                    <div class="rounded-2xl border border-amber-200/60 bg-amber-50/20 p-5 sm:p-6 shadow-sm mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-display text-sm font-bold text-amber-900 flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-amber-500 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span>Rekomendasi untuk Anda</span>
                            </h3>
                            <span class="text-[9px] font-bold text-amber-700 bg-amber-500/10 rounded-full px-2 py-0.5 uppercase tracking-wide">Featured</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($recommendedProducts as $p)
                                <x-product-card :product="$p" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-exportani-border pb-3.5">
                        <h3 class="font-display text-sm font-bold text-exportani-text">
                            @if(request()->anyFilled(['q', 'category_id', 'location', 'min_price', 'max_price', 'trusted_only', 'recommended_only']))
                                Hasil Pencarian
                            @else
                                Semua Produk
                            @endif
                        </h3>
                        <span class="text-xs text-exportani-secondaryText font-medium">
                            Menampilkan {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @forelse ($products as $p)
                            <x-product-card :product="$p" />
                        @empty
                            <div class="col-span-full rounded-2xl border border-dashed border-exportani-border bg-white px-6 py-16 text-center shadow-sm">
                                <svg class="mx-auto h-12 w-12 text-exportani-secondaryText/60 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <h3 class="text-lg font-bold text-exportani-text font-display">Produk tidak ditemukan</h3>
                                <p class="mt-1 text-sm text-exportani-secondaryText">Coba gunakan kata kunci atau filter lain yang lebih umum.</p>
                                @if(request()->anyFilled(['q', 'category_id', 'location', 'min_price', 'max_price']))
                                    <div class="mt-6">
                                        <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-xl bg-exportani-primary hover:bg-exportani-dark px-4 py-2 text-xs font-semibold text-white shadow-sm transition">
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
