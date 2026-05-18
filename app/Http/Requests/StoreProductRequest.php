<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'regex:/^[a-zA-Z0-9\s\-()]+$/'
            ],
            'deskripsi' => [
                'required',
                'string',
            ],
            'kategori_id' => [
                'required',
                'exists:categories,id',
            ],
            'harga' => [
                'required',
                'numeric',
                'min:0',
            ],
            'gambar' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048', // max 2MB
            ],
            'jumlah' => [
                'required',
                'integer',
                'min:1',
                'max:999999'
            ],
            'lokasi' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.string' => 'Nama produk harus berupa teks',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter',
            'nama_produk.min' => 'Nama produk minimal 3 karakter',
            'nama_produk.regex' => 'Nama produk hanya boleh mengandung huruf, angka, spasi, dan tanda hubung',
            
            'deskripsi.required' => 'Deskripsi produk harus diisi',
            'kategori_id.required' => 'Kategori produk harus dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'harga.required' => 'Harga produk harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'gambar.required' => 'Gambar produk wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
            
            'jumlah.required' => 'Jumlah produk harus diisi',
            'jumlah.integer' => 'Jumlah produk harus berupa angka',
            'jumlah.min' => 'Jumlah produk minimal 1',
            'jumlah.max' => 'Jumlah produk maksimal 999.999',
            
            'lokasi.required' => 'Lokasi produk harus diisi',
            'lokasi.string' => 'Lokasi harus berupa teks',
            'lokasi.max' => 'Lokasi maksimal 255 karakter',
            'lokasi.min' => 'Lokasi minimal 3 karakter',
        ];
    }
}
