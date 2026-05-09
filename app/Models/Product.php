<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Partnership;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'jumlah',
        'lokasi',
        'user_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function partnerships()
    {
        return $this->hasMany(Partnership::class);
    }
}
