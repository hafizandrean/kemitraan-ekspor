<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produk Saya') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('petani.products.create') }}">
                    <x-primary-button>Tambah Produk</x-primary-button>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="space-y-4">
                    @forelse ($products as $p)
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $p->nama_produk }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                Jumlah: <span class="font-medium">{{ $p->jumlah }}</span>
                                <span class="mx-2">•</span>
                                Lokasi: <span class="font-medium">{{ $p->lokasi }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-600 dark:text-gray-300">
                            Kamu belum punya produk. Klik "Tambah Produk" untuk mulai.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

