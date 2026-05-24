<?php

namespace App\Http\Requests;

use App\Support\IndonesiaLocations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('product')->user_id === auth()->id();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'harga' => preg_replace('/\D/', '', (string) $this->input('harga', '')),
            'jumlah' => preg_replace('/\D/', '', (string) $this->input('jumlah', '')),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_produk' => ['required', 'string', 'max:255', 'min:3', 'regex:/^[a-zA-Z0-9\s\-()]+$/'],
            'deskripsi' => ['required', 'string'],
            'kategori_id' => ['required', 'exists:categories,id'],
            'harga' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'array', 'max:5'],
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
            'deskripsi.required' => 'Deskripsi produk harus diisi',
            'kategori_id.required' => 'Kategori produk harus dipilih',
            'harga.required' => 'Harga produk harus diisi',
            'gambar.max' => 'Maksimal 5 foto per produk',
            'gambar.*.max' => 'Setiap foto maksimal 5MB',
            'lokasi.in' => 'Pilih lokasi dari daftar kabupaten/kota yang tersedia',
        ];
    }
}
