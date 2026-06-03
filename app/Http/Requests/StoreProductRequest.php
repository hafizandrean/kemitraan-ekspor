<?php

namespace App\Http\Requests;

use App\Support\IndonesiaLocations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $harga = $this->input('harga');
        $jumlah = $this->input('jumlah');

        $this->merge([
            'harga' => is_string($harga) ? str_replace('.', '', $harga) : $harga,
            'jumlah' => is_string($jumlah) ? str_replace('.', '', $jumlah) : $jumlah,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_produk' => ['required', 'string', 'max:255', 'min:3', 'regex:/^[a-zA-Z0-9\s\-()]+$/'],
            'deskripsi' => ['required', 'string'],
            'kategori_id' => ['required', 'exists:categories,id'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['required', 'array', 'min:1', 'max:5'],
            'gambar.*' => ['file', 'max:5120'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:999999'],
            'satuan' => ['required', Rule::in(['kg', 'ton'])],
            'lokasi' => ['required', 'string', Rule::in(IndonesiaLocations::all())],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.regex' => 'Nama produk hanya boleh mengandung huruf, angka, spasi, dan tanda hubung',
            'deskripsi.required' => 'Deskripsi produk harus diisi',
            'kategori_id.required' => 'Kategori produk harus dipilih',
            'harga.required' => 'Harga produk harus diisi',
            'gambar.required' => 'Minimal 1 foto produk wajib diupload',
            'gambar.max' => 'Maksimal 5 foto per produk',
            'gambar.*.max' => 'Setiap foto maksimal 5MB',
            'gambar.*.uploaded' => 'Upload gagal. Periksa ukuran atau format file.',
            'jumlah.required' => 'Stok produk harus diisi',
            'satuan.required' => 'Satuan stok harus dipilih',
            'lokasi.required' => 'Lokasi harus dipilih dari daftar',
            'lokasi.in' => 'Pilih lokasi dari daftar kabupaten/kota yang tersedia',
        ];
    }
}
