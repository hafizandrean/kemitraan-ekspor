<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">
                Produk Favorit
            </h2>
            <p class="mt-1 text-sm text-exportani-secondaryText">
                Daftar produk yang kamu simpan.
            </p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">

            @if (session('success'))
                <div class="rounded-xl border border-exportani-mint/30 bg-exportani-mint/10 px-4 py-3 text-sm font-medium text-exportani-accent shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($products->isEmpty())
                <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 p-10 text-center">
                    <p class="text-stone-600">
                        Belum ada produk favorit.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>