<?php

namespace Tests\Feature;

use App\Models\Partnership;
use App\Models\Product;
use App\Models\SystemNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MvpFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_petani_can_create_product_and_eksportir_can_search_apply_and_petani_can_accept(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);

        // Seed default subscription plans (required for applying premium limits check)
        \App\Models\SubscriptionPlan::create([
            'name' => 'Free',
            'price' => 0,
            'duration_days' => 0,
            'description' => 'Free plan',
            'features' => ['basic search'],
        ]);

        $petani = User::factory()->create(['role' => 'petani']);
        $eksportir = User::factory()->create(['role' => 'eksportir']);
        $category = \App\Models\Category::first();

        // Petani creates product
        $this->actingAs($petani)
            ->post(route('petani.products.store'), [
                'nama_produk' => 'Kopi Arabika',
                'deskripsi' => 'Kopi Arabika premium hasil panen Gayo',
                'kategori_id' => $category->id,
                'harga' => 120000,
                'jumlah' => 100,
                'satuan' => 'kg',
                'lokasi' => 'Kab. Aceh Tengah',
                'gambar' => [UploadedFile::fake()->image('kopi.jpg')],
            ])
            ->assertRedirect(route('petani.products.index'));

        $product = Product::query()->where('nama_produk', 'Kopi Arabika')->firstOrFail();

        // Eksportir searches product
        $this->actingAs($eksportir)
            ->get(route('products.index', ['q' => 'Arabika']))
            ->assertStatus(200)
            ->assertSee('Kopi Arabika');

        // Eksportir applies partnership (pending)
        $this->actingAs($eksportir)
            ->post(route('partnerships.apply', $product))
            ->assertStatus(302);

        $partnership = Partnership::query()->where('product_id', $product->id)->firstOrFail();
        $petaniNotif = SystemNotification::query()->where('user_id', $petani->id)->latest()->first();
        
        $this->assertSame('pending', $partnership->status);
        $this->assertSame($petani->id, $partnership->petani_id);
        $this->assertSame($eksportir->id, $partnership->eksportir_id);
        $this->assertNotNull($petaniNotif);
        $this->assertStringContainsString('mengajukan kerja sama', $petaniNotif->message);

        // Petani sees request list
        $this->actingAs($petani)
            ->get(route('requests.index'))
            ->assertStatus(200)
            ->assertSee('pending')
            ->assertSee('Kopi Arabika');

        // Petani accepts request
        $this->actingAs($petani)
            ->post(route('requests.accept', $partnership->id))
            ->assertStatus(302);

        $partnership->refresh();
        $eksportirNotif = SystemNotification::query()->where('user_id', $eksportir->id)->latest()->first();
        
        $this->assertSame('active', $partnership->status);
        $this->assertNotNull($eksportirNotif);
        $this->assertStringContainsString('diterima', $eksportirNotif->message);
    }

    public function test_petani_cannot_apply_and_eksportir_cannot_accept_or_view_requests(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $petani = User::factory()->create(['role' => 'petani']);
        $eksportir = User::factory()->create(['role' => 'eksportir']);
        $category = \App\Models\Category::first();

        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'kategori_id' => $category->id,
            'nama_produk' => 'Jagung',
            'jumlah' => 10,
            'lokasi' => 'Kab. Lombok Tengah',
        ]);

        // Petani cannot apply
        $this->actingAs($petani)
            ->post(route('partnerships.apply', $product))
            ->assertStatus(403);

        // Eksportir cannot view requests
        $this->actingAs($eksportir)
            ->get(route('requests.index'))
            ->assertStatus(403);
    }
}
