<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                Produk Favorit
            </h2>
            <p class="mt-1 text-sm text-stone-600">Daftar produk yang kamu simpan.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-3">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($products as $product)
                <a href="{{ route('products.show', $product) }}" class="block rounded-xl border border-stone-200 bg-white p-5 hover:border-emerald-300 transition">
                    <p class="font-semibold text-stone-900">{{ $product->nama_produk }}</p>
                    <p class="mt-1 text-sm text-stone-600">Jumlah {{ $product->jumlah }} • {{ $product->lokasi }}</p>
                </a>
            @empty
                <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 p-10 text-center text-stone-600">
                    Belum ada produk favorit.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

