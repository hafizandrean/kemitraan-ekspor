<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Pastikan user hanya bisa edit produk miliknya sendiri
        return $this->route('product')->user_id === auth()->id();
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
                'sometimes',
                'string',
                'max:255',
                'min:3',
                'regex:/^[a-zA-Z0-9\s\-()]+$/'
            ],
            'jumlah' => [
                'sometimes',
                'integer',
                'min:1',
                'max:999999'
            ],
            'lokasi' => [
                'sometimes',
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
            'nama_produk.string' => 'Nama produk harus berupa teks',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter',
            'nama_produk.min' => 'Nama produk minimal 3 karakter',
            'nama_produk.regex' => 'Nama produk hanya boleh mengandung huruf, angka, spasi, dan tanda hubung',
            
            'jumlah.integer' => 'Jumlah produk harus berupa angka',
            'jumlah.min' => 'Jumlah produk minimal 1',
            'jumlah.max' => 'Jumlah produk maksimal 999.999',
            
            'lokasi.string' => 'Lokasi harus berupa teks',
            'lokasi.max' => 'Lokasi maksimal 255 karakter',
            'lokasi.min' => 'Lokasi minimal 3 karakter',
        ];
    }
}
