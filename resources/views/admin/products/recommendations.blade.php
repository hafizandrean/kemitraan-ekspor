<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Rekomendasi Produk</h2>
            <p class="mt-1 text-sm text-stone-600">Pilih produk yang ditampilkan di halaman utama dan bagian rekomendasi eksportir.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('success') }}</div>
        @endif

        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            Saat ini <strong>{{ $recommendedCount }}</strong> produk ditandai sebagai rekomendasi.
        </div>

        <form method="GET" class="flex gap-3">
            <x-text-input name="q" value="{{ $q }}" placeholder="Cari nama produk..." class="flex-1" />
            <x-primary-button type="submit">Cari</x-primary-button>
        </form>

        <div class="rounded-2xl border border-stone-200 bg-white overflow-hidden shadow-sm divide-y divide-stone-100">
            @forelse ($products as $product)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5">
                    <div>
                        <p class="font-semibold text-stone-900">{{ $product->nama_produk }}</p>
                        <p class="text-sm text-stone-500">
                            {{ $product->category?->name ?? 'Tanpa kategori' }} · {{ $product->owner?->name }}
                        </p>
                    </div>
                    <form method="POST" action="{{ route('admin.recommendations.toggle', $product) }}">
                        @csrf
                        @if ($product->is_recommended)
                            <button type="submit" class="rounded-lg border border-stone-300 px-4 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">
                                Hapus Rekomendasi
                            </button>
                        @else
                            <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600">
                                Jadikan Rekomendasi
                            </button>
                        @endif
                    </form>
                </div>
            @empty
                <p class="p-8 text-center text-stone-500">Produk tidak ditemukan.</p>
            @endforelse
        </div>

        {{ $products->links() }}
    </div>
</x-app-layout>
