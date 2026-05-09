<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                {{ __('Cari produk') }}
            </h2>
            <p class="mt-1 text-sm text-stone-600">Cari berdasarkan nama produk dari petani.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-6">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-6 sm:p-8 shadow-sm shadow-stone-900/5">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-stretch">
                    <input
                        type="text"
                        name="q"
                        value="{{ $q }}"
                        placeholder="Ketik nama produk…"
                        class="w-full flex-1 rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm placeholder:text-stone-400 focus:border-emerald-500 focus:ring-emerald-500"
                    />
                    <x-primary-button type="submit" class="shrink-0 justify-center sm:w-auto">Cari</x-primary-button>
                </form>

                <div class="mt-8 space-y-3">
                    @forelse ($products as $p)
                        <a href="{{ route('products.show', $p) }}" class="group flex items-start justify-between gap-4 rounded-xl border border-stone-200/80 bg-stone-50/50 p-5 transition hover:border-emerald-300 hover:bg-white hover:shadow-md hover:shadow-emerald-900/5">
                            <div class="min-w-0">
                                <div class="font-display text-lg font-semibold text-stone-900 group-hover:text-emerald-800 truncate">
                                    {{ $p->nama_produk }}
                                </div>
                                <div class="mt-1.5 flex flex-wrap gap-x-3 gap-y-1 text-sm text-stone-600">
                                    <span>Jumlah <strong class="text-stone-800">{{ $p->jumlah }}</strong></span>
                                    <span class="hidden sm:inline text-stone-300">|</span>
                                    <span>Lokasi <strong class="text-stone-800">{{ $p->lokasi }}</strong></span>
                                </div>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-emerald-600 group-hover:text-emerald-700">
                                Detail →
                            </span>
                        </a>
                    @empty
                        <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 px-6 py-12 text-center text-stone-600">
                            Belum ada produk yang cocok. Coba kata kunci lain.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
