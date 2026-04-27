<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;

class Partnership extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'petani_id',
        'eksportir_id',
        'status'
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke petani
    public function petani()
    {
        return $this->belongsTo(User::class, 'petani_id');
    }

    // Relasi ke eksportir
    public function eksportir()
    {
        return $this->belongsTo(User::class, 'eksportir_id');
    }
}