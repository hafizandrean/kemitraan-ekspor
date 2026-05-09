@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Produk</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong>Error validasi:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST" id="productForm">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Produk
                </label>
                <input type="text" 
                       id="nama_produk" 
                       name="nama_produk" 
                       value="{{ old('nama_produk', $product->nama_produk) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nama_produk') border-red-500 @enderror"
                       placeholder="Misal: Beras Premium">
                @error('nama_produk')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Min 3 karakter, hanya alfanumerik dan tanda hubung</p>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">
                    Jumlah (kg)
                </label>
                <input type="number" 
                       id="jumlah" 
                       name="jumlah" 
                       value="{{ old('jumlah', $product->jumlah) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('jumlah') border-red-500 @enderror"
                       min="1"
                       max="999999">
                @error('jumlah')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Min 1 kg, max 999.999 kg</p>
            </div>

            <div class="mb-6">
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">
                    Lokasi
                </label>
                <input type="text" 
                       id="lokasi" 
                       name="lokasi" 
                       value="{{ old('lokasi', $product->lokasi) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('lokasi') border-red-500 @enderror"
                       placeholder="Misal: Karawang, Jawa Barat">
                @error('lokasi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Min 3 karakter</p>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 py-2 px-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Real-time validation feedback (opsional)
const form = document.getElementById('productForm');
const namaProduk = document.getElementById('nama_produk');
const jumlah = document.getElementById('jumlah');
const lokasi = document.getElementById('lokasi');

namaProduk.addEventListener('blur', function() {
    if (this.value.length > 0 && this.value.length < 3) {
        this.classList.add('border-yellow-500');
    } else {
        this.classList.remove('border-yellow-500');
    }
});

jumlah.addEventListener('blur', function() {
    if (this.value && (this.value < 1 || this.value > 999999)) {
        this.classList.add('border-yellow-500');
    } else {
        this.classList.remove('border-yellow-500');
    }
});

lokasi.addEventListener('blur', function() {
    if (this.value.length > 0 && this.value.length < 3) {
        this.classList.add('border-yellow-500');
    } else {
        this.classList.remove('border-yellow-500');
    }
});
</script>
@endsection
