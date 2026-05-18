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
        'farmer_id',
        'exporter_id',
        'status'
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke petani (farmer)
    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    // Relasi ke eksportir (exporter)
    public function exporter()
    {
        return $this->belongsTo(User::class, 'exporter_id');
    }
}