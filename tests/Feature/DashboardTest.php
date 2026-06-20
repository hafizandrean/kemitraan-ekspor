<?php

namespace Tests\Feature;

use App\Models\Partnership;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_petani_dashboard_shows_stats(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $petani = User::factory()->create(['role' => 'petani']);
        $eksportir = User::factory()->create(['role' => 'eksportir']);
        $product = Product::factory()->create(['user_id' => $petani->id, 'jumlah' => 12]);
        Partnership::factory()->create([
            'product_id' => $product->id,
            'petani_id' => $petani->id,
            'eksportir_id' => $eksportir->id,
            'status' => 'pending',
        ]);

        $this->actingAs($petani)
            ->followingRedirects()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Petani')
            ->assertSee('Total Produk')
            ->assertSee('Pengajuan Masuk');
    }

    public function test_eksportir_dashboard_shows_stats(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $petani = User::factory()->create(['role' => 'petani']);
        $eksportir = User::factory()->create(['role' => 'eksportir']);
        $product = Product::factory()->create(['user_id' => $petani->id]);
        Partnership::factory()->create([
            'product_id' => $product->id,
            'petani_id' => $petani->id,
            'eksportir_id' => $eksportir->id,
            'status' => 'active',
        ]);

        $this->actingAs($eksportir)
            ->followingRedirects()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Eksportir')
            ->assertSee('Jumlah Pengajuan')
            ->assertSee('Kerja Sama Aktif');
    }
}
