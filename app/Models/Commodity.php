<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit'];

    public function prices()
    {
        return $this->hasMany(CommodityPrice::class);
    }

    public function latestPrice()
    {
        return $this->hasOne(CommodityPrice::class)->latestOfMany('recorded_date');
    }

    public function scopeWithLatestPrice($query)
    {
        return $query->with('latestPrice');
    }
}
