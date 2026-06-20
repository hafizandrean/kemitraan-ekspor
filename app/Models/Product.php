<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'jumlah',
        'satuan',
        'lokasi',
        'gambar',
        'user_id',
        'kategori_id',
        'is_recommended',
        'recommended_at',
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
        'recommended_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function partnerships(): HasMany
    {
        return $this->hasMany(Partnership::class);
    }

    public function favoredByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    public function scopeRecommended(Builder $query): Builder
    {
        return $query->where('is_recommended', true)->orderByDesc('recommended_at');
    }
}
