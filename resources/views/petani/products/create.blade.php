<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                {{ __('Tambah produk') }}
            </h2>
            <p class="mt-1 text-sm text-stone-600">Isi data komoditas yang ingin ditawarkan kepada eksportir.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-6 sm:p-8 shadow-sm shadow-stone-900/5 backdrop-blur-md">
                <form method="POST" action="{{ route('petani.products.store') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-5">
                            <div>
                                <x-input-label for="nama_produk" value="Nama produk" />
                                <x-text-input id="nama_produk" name="nama_produk" type="text" class="mt-1.5 block w-full" :value="old('nama_produk')" required minlength="3" maxlength="255" />
                                <p class="mt-1 text-xs text-stone-500">Min 3 karakter. Huruf, angka, spasi, tanda hubung.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                            </div>

                            <div>
                                <x-input-label for="kategori_id" value="Kategori" />
                                <select id="kategori_id" name="kategori_id" class="mt-1.5 block w-full border-stone-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" required>
                                    <option value="" disabled selected>Pilih kategori...</option>
                                    @foreach($categories as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('kategori_id')" />
                            </div>

                            <div>
                                <x-input-label for="harga" value="Harga (Rp)" />
                                <x-text-input id="harga" name="harga" type="number" min="0" class="mt-1.5 block w-full" :value="old('harga')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                            </div>
                            
                            <div>
                                <x-input-label for="jumlah" value="Stok / Jumlah (kg)" />
                                <x-text-input id="jumlah" name="jumlah" type="number" min="1" max="999999" class="mt-1.5 block w-full" :value="old('jumlah')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                            </div>

                            <div>
                                <x-input-label for="lokasi" value="Lokasi (Kota/Kabupaten)" />
                                <x-text-input id="lokasi" name="lokasi" type="text" class="mt-1.5 block w-full" :value="old('lokasi')" required minlength="3" maxlength="255" />
                                <x-input-error class="mt-2" :messages="$errors->get('lokasi')" />
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-5">
                            <div>
                                <x-input-label for="deskripsi" value="Deskripsi Produk" />
                                <textarea id="deskripsi" name="deskripsi" rows="5" class="mt-1.5 block w-full border-stone-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" required>{{ old('deskripsi') }}</textarea>
                                <p class="mt-1 text-xs text-stone-500">Jelaskan kualitas, varietas, atau keunggulan komoditas Anda.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                            </div>

                            <div>
                                <x-input-label for="gambar" value="Gambar Produk" />
                                <div class="mt-1.5 flex justify-center rounded-lg border border-dashed border-stone-300 px-6 py-8 hover:border-emerald-500 bg-stone-50 transition-colors">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-stone-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-stone-600 justify-center">
                                            <label for="gambar" class="relative cursor-pointer rounded-md bg-white font-semibold text-emerald-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-emerald-600 focus-within:ring-offset-2 hover:text-emerald-500">
                                                <span>Upload file</span>
                                                <input id="gambar" name="gambar" type="file" class="sr-only" accept="image/*" required>
                                            </label>
                                        </div>
                                        <p class="text-xs leading-5 text-stone-500">PNG, JPG, WEBP maks 2MB</p>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('gambar')" />
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 pt-6 border-t border-stone-200 sm:flex-row sm:justify-end mt-8">
                        <a href="{{ route('petani.products.index') }}" class="inline-flex items-center justify-center text-sm font-semibold text-stone-600 hover:text-emerald-800 sm:mr-auto">
                            Batal
                        </a>
                        <x-primary-button class="justify-center bg-emerald-600 hover:bg-emerald-700">Simpan produk</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
