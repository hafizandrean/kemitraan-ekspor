<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ $product->nama_produk }}
                </div>

                <div class="mt-3 text-gray-700 dark:text-gray-200">
                    <div><span class="font-medium">Jumlah:</span> {{ $product->jumlah }}</div>
                    <div class="mt-1"><span class="font-medium">Lokasi:</span> {{ $product->lokasi }}</div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <form method="POST" action="{{ route('partnerships.apply', $product) }}">
                        @csrf
                        <x-primary-button>Ajukan Kerja Sama</x-primary-button>
                    </form>

                    <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

