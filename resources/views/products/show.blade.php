<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                {{ __('Detail produk') }}
            </h2>
            <p class="mt-1 text-sm text-stone-600">Tinjau informasi sebelum mengajukan kerja sama.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto space-y-6">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-8 shadow-sm shadow-stone-900/5">
                <h3 class="font-display text-2xl font-semibold text-stone-900">
                    {{ $product->nama_produk }}
                </h3>

                <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl bg-stone-50 px-4 py-3 ring-1 ring-stone-200/80">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Jumlah</dt>
                        <dd class="mt-1 text-lg font-semibold text-stone-900">{{ $product->jumlah }}</dd>
                    </div>
                    <div class="rounded-xl bg-stone-50 px-4 py-3 ring-1 ring-stone-200/80">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Lokasi</dt>
                        <dd class="mt-1 text-lg font-semibold text-stone-900">{{ $product->lokasi }}</dd>
                    </div>
                </dl>

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between border-t border-stone-200/80 pt-8">
                    <a href="{{ route('products.index') }}" class="text-sm font-semibold text-stone-600 hover:text-emerald-800">
                        ← Kembali ke daftar
                    </a>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <form method="POST" action="{{ route('favorites.toggle', $product) }}">
                            @csrf
                            <x-secondary-button class="w-full sm:w-auto justify-center">Toggle Favorit</x-secondary-button>
                        </form>
                        <form method="POST" action="{{ route('partnerships.apply', $product) }}">
                            @csrf
                            <x-primary-button class="w-full sm:w-auto justify-center">Ajukan kerja sama</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
