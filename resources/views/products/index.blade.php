<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produk') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('products.index') }}" class="flex gap-2 mb-6">
                    <input
                        type="text"
                        name="q"
                        value="{{ $q }}"
                        placeholder="Cari nama produk..."
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    />
                    <x-primary-button>Cari</x-primary-button>
                </form>

                <div class="space-y-4">
                    @forelse ($products as $p)
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $p->nama_produk }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        Jumlah: <span class="font-medium">{{ $p->jumlah }}</span>
                                        <span class="mx-2">•</span>
                                        Lokasi: <span class="font-medium">{{ $p->lokasi }}</span>
                                    </div>
                                </div>

                                <a
                                    href="{{ route('products.show', $p) }}"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                                >
                                    Lihat detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-600 dark:text-gray-300">
                            Tidak ada produk.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

