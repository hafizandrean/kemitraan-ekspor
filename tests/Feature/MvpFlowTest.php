<?php

namespace Tests\Feature;

use App\Models\Partnership;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MvpFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_petani_can_create_product_and_eksportir_can_search_apply_and_petani_can_accept(): void
    {
        $petani = User::factory()->create(['role' => 'petani']);
        $eksportir = User::factory()->create(['role' => 'eksportir']);

        // Petani creates product
        $this->actingAs($petani)
            ->post(route('petani.products.store'), [
                'nama_produk' => 'Kopi Arabika',
                'jumlah' => 100,
                'lokasi' => 'Aceh',
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
        $this->assertSame('pending', $partnership->status);
        $this->assertSame($petani->id, $partnership->petani_id);
        $this->assertSame($eksportir->id, $partnership->eksportir_id);

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
        $this->assertSame('accepted', $partnership->status);
    }

    public function test_petani_cannot_apply_and_eksportir_cannot_accept_or_view_requests(): void
    {
        $petani = User::factory()->create(['role' => 'petani']);
        $eksportir = User::factory()->create(['role' => 'eksportir']);

        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'nama_produk' => 'Jagung',
            'jumlah' => 10,
            'lokasi' => 'NTB',
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

