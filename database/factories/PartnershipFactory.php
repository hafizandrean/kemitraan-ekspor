<?php

namespace Database\Factories;

use App\Models\Partnership;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partnership>
 */
class PartnershipFactory extends Factory
{
    protected $model = Partnership::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'petani_id' => User::factory(),
            'eksportir_id' => User::factory(),
            'status' => 'pending',
        ];
    }
}

