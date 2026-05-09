<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'jumlah',
        'lokasi',
        'user_id'
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Validasi rules untuk product
     */
    public static array $rules = [
        'nama_produk' => [
            'required',
            'string',
            'max:255',
            'min:3',
            'regex:/^[a-zA-Z0-9\s\-()]+$/'
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

    /**
     * Pesan validasi custom
     */
    public static array $messages = [
        'nama_produk.required' => 'Nama produk harus diisi',
        'nama_produk.string' => 'Nama produk harus berupa teks',
        'nama_produk.max' => 'Nama produk maksimal 255 karakter',
        'nama_produk.min' => 'Nama produk minimal 3 karakter',
        'nama_produk.regex' => 'Nama produk hanya boleh mengandung huruf, angka, spasi, dan tanda hubung',
        
        'jumlah.required' => 'Jumlah produk harus diisi',
        'jumlah.integer' => 'Jumlah produk harus berupa angka',
        'jumlah.min' => 'Jumlah produk minimal 1',
        'jumlah.max' => 'Jumlah produk maksimal 999.999',
        
        'lokasi.required' => 'Lokasi produk harus diisi',
        'lokasi.string' => 'Lokasi harus berupa teks',
        'lokasi.max' => 'Lokasi maksimal 255 karakter',
        'lokasi.min' => 'Lokasi minimal 3 karakter',
    ];

    /**
     * Get the user that owns the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the partnerships for the product.
     */
    public function partnerships(): HasMany
    {
        return $this->hasMany(Partnership::class);
    }
}
