<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                {{ __('Tambah produk') }}
            </h2>
            <p class="mt-1 text-sm text-stone-600">Isi data komoditas yang ingin ditawarkan.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-6 sm:p-8 shadow-sm shadow-stone-900/5">
                <form method="POST" action="{{ route('petani.products.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="nama_produk" value="Nama produk" />
                        <x-text-input id="nama_produk" name="nama_produk" type="text" class="mt-1.5 block w-full" :value="old('nama_produk')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                    </div>

                    <div>
                        <x-input-label for="jumlah" value="Jumlah" />
                        <x-text-input id="jumlah" name="jumlah" type="number" min="1" class="mt-1.5 block w-full" :value="old('jumlah')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                    </div>

                    <div>
                        <x-input-label for="lokasi" value="Lokasi" />
                        <x-text-input id="lokasi" name="lokasi" type="text" class="mt-1.5 block w-full" :value="old('lokasi')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('lokasi')" />
                    </div>

                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                        <a href="{{ route('petani.products.index') }}" class="inline-flex items-center justify-center text-sm font-semibold text-stone-600 hover:text-emerald-800 sm:mr-auto">
                            Batal
                        </a>
                        <x-primary-button class="justify-center">Simpan produk</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
