<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('petani.products.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="nama_produk" value="Nama produk" />
                        <x-text-input id="nama_produk" name="nama_produk" type="text" class="mt-1 block w-full" :value="old('nama_produk')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                    </div>

                    <div>
                        <x-input-label for="jumlah" value="Jumlah" />
                        <x-text-input id="jumlah" name="jumlah" type="number" min="1" class="mt-1 block w-full" :value="old('jumlah')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                    </div>

                    <div>
                        <x-input-label for="lokasi" value="Lokasi" />
                        <x-text-input id="lokasi" name="lokasi" type="text" class="mt-1 block w-full" :value="old('lokasi')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('lokasi')" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('petani.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

