@php
    $product = $product ?? null;
    $isEdit = $product !== null;
    $locations = \App\Support\IndonesiaLocations::all();
    $existingImages = $product?->images ?? collect();
    if ($product && $existingImages->isEmpty() && $product->gambar) {
        $existingImages = collect([(object) ['path' => $product->gambar]]);
    }
    $hargaDisplay = old('harga', $product?->harga ? number_format((float) $product->harga, 0, ',', '.') : '');
    $jumlahDisplay = old('jumlah', $product?->jumlah ? number_format((int) $product->jumlah, 0, ',', '.') : '');
    $satuan = old('satuan', $product?->satuan ?? 'kg');
@endphp

<div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
    {{-- Kolom kiri: informasi dasar + harga & logistik --}}
    <div class="space-y-6">
        <x-product-form-card title="Detail Produk" icon="📝">
            <div class="space-y-4">
                <div>
                    <x-input-label for="nama_produk" value="Nama produk" />
                    <x-text-input id="nama_produk" name="nama_produk" type="text" class="mt-1.5 block w-full"
                        :value="old('nama_produk', $product?->nama_produk)" required minlength="3" maxlength="255" />
                    <p class="mt-1 text-xs text-stone-500">Min 3 karakter. Huruf, angka, spasi, tanda hubung.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                </div>
                <div>
                    <x-input-label for="kategori_id" value="Kategori" />
                    <select id="kategori_id" name="kategori_id" class="mt-1.5 block w-full rounded-lg border-stone-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        <option value="" disabled @selected(!old('kategori_id', $product?->kategori_id))>Pilih kategori...</option>
                        @foreach($categories as $kategori)
                            <option value="{{ $kategori->id }}" @selected(old('kategori_id', $product?->kategori_id) == $kategori->id)>{{ $kategori->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('kategori_id')" />
                </div>
            </div>
        </x-product-form-card>

        <x-product-form-card title="Harga & Logistik" icon="💰">
            <div class="space-y-4">
                <div>
                    <x-input-label for="harga_display" value="Harga per kg" />
                    <div class="relative mt-1.5">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm font-semibold text-stone-500">Rp</span>
                        <input
                            id="harga_display"
                            type="text"
                            inputmode="numeric"
                            data-format-ribuan
                            data-target-name="harga"
                            value="{{ $hargaDisplay }}"
                            class="block w-full rounded-lg border-stone-300 pl-10 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="0"
                            required
                        >
                        <input type="hidden" name="harga" id="harga" value="{{ old('harga', $product?->harga) }}">
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                </div>

                <div>
                    <x-input-label for="jumlah_display" value="Stok tersedia" />
                    <div class="relative mt-1.5 flex">
                        <input
                            id="jumlah_display"
                            type="text"
                            inputmode="numeric"
                            data-format-ribuan
                            data-target-name="jumlah"
                            value="{{ $jumlahDisplay }}"
                            class="block w-full rounded-l-lg border-stone-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="0"
                            required
                        >
                        <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah', $product?->jumlah) }}">
                        <select name="satuan" class="rounded-r-lg border border-l-0 border-stone-300 bg-stone-50 px-3 text-sm font-medium text-stone-700 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="kg" @selected($satuan === 'kg')>Kg</option>
                            <option value="ton" @selected($satuan === 'ton')>Ton</option>
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                </div>

                <div>
                    <x-location-search
                        name="lokasi"
                        :value="old('lokasi', $product?->lokasi)"
                        :locations="$locations"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('lokasi')" />
                </div>
            </div>
        </x-product-form-card>
    </div>

    {{-- Kolom kanan: media + deskripsi + tips --}}
    <div class="space-y-6">
        <x-product-form-card title="Media & Visual" icon="📸">
            <x-product-images-upload
                :required="!$isEdit && $existingImages->isEmpty()"
                :existing-images="$existingImages"
            />
            <x-input-error class="mt-2" :messages="$errors->get('gambar')" />
            <x-input-error class="mt-2" :messages="$errors->get('gambar.*')" />
        </x-product-form-card>

        <x-product-form-card title="Deskripsi" icon="📄">
            <div>
                <x-input-label for="deskripsi" value="Deskripsi produk" />
                <textarea id="deskripsi" name="deskripsi" rows="6" class="mt-1.5 block w-full rounded-lg border-stone-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required placeholder="Varietas, kualitas, kapasitas bulanan, sertifikasi, dll.">{{ old('deskripsi', $product?->deskripsi) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
            </div>
        </x-product-form-card>

        <div class="rounded-xl border border-amber-200 bg-amber-50/80 p-4 text-sm text-amber-950">
            <p class="font-semibold">💡 Tips jualan ekspor</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-amber-900/90">
                <li>Gunakan foto terang: produk, kemasan, dan area sortir/gudang.</li>
                <li>Deskripsikan varietas (mis. Cabe Merah Keriting grade A).</li>
                <li>Foto iPhone (HEIC) otomatis dikonversi — tidak perlu edit manual.</li>
            </ul>
        </div>
    </div>
</div>

<div class="mt-8 flex flex-col-reverse items-center gap-3 border-t border-stone-200 pt-6 sm:flex-row sm:justify-end">
    <a href="{{ route('petani.products.index') }}" class="inline-flex w-full items-center justify-center rounded-lg border border-stone-300 px-5 py-2.5 text-sm font-semibold text-stone-700 transition hover:bg-stone-50 sm:w-auto sm:mr-auto">
        Batal
    </a>
    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:scale-[0.98] sm:w-auto">
        {{ $isEdit ? 'Simpan perubahan' : 'Simpan produk' }}
    </button>
</div>

<script>
(function () {
    function parseRibuan(value) {
        return (value || '').replace(/\./g, '').replace(/[^\d]/g, '');
    }

    function formatRibuan(value) {
        const digits = parseRibuan(value);
        if (!digits) return '';
        return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.querySelectorAll('[data-format-ribuan]').forEach((input) => {
        const hidden = document.querySelector('[name="' + input.dataset.targetName + '"]');
        if (!hidden) return;

        input.addEventListener('input', () => {
            const raw = parseRibuan(input.value);
            input.value = formatRibuan(raw);
            hidden.value = raw;
        });

        if (input.value) {
            const raw = parseRibuan(input.value);
            hidden.value = raw;
            input.value = formatRibuan(raw);
        }
    });
})();
</script>
