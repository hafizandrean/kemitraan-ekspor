<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'nama_produk' => fake()->words(2, true),
            'jumlah' => fake()->numberBetween(1, 1000),
            'lokasi' => fake()->city(),
            'user_id' => User::factory(),
        ];
    }
}

