<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                Produk Favorit
            </h2>
            <p class="mt-1 text-sm text-stone-600">
                Daftar produk yang kamu simpan.
            </p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-4">

            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($products as $product)

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm hover:shadow-md transition">

                    <a href="{{ route('products.show', $product) }}" class="block">

                        <h3 class="text-lg font-semibold text-stone-900">
                            {{ $product->nama_produk }}
                        </h3>

                        <p class="mt-2 text-sm text-stone-600">
                            Jumlah: {{ $product->jumlah }}
                        </p>

                        <p class="text-sm text-stone-600">
                            Lokasi: {{ $product->lokasi }}
                        </p>

                        <p class="mt-2 text-lg font-bold text-emerald-600">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </p>

                    </a>

                    <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="mt-4">
                        @csrf

                        <button
                            type="submit"
                            class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white hover:bg-red-600 transition">
                            Hapus dari Favorit
                        </button>
                    </form>

                </div>

            @empty

                <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 p-10 text-center">
                    <p class="text-stone-600">
                        Belum ada produk favorit.
                    </p>
                </div>

            @endforelse

        </div>
    </div>
</x-app-layout>