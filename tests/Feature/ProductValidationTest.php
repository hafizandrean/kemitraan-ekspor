<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_rejects_invalid_product_data(): void
    {
        $petani = User::factory()->create(['role' => 'petani']);

        $this->actingAs($petani)
            ->from(route('petani.products.create'))
            ->post(route('petani.products.store'), [
                'nama_produk' => 'AB',
                'jumlah' => 0,
                'lokasi' => 'X',
            ])
            ->assertRedirect(route('petani.products.create'))
            ->assertSessionHasErrors(['nama_produk', 'jumlah', 'lokasi']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_store_rejects_invalid_product_name_characters(): void
    {
        $petani = User::factory()->create(['role' => 'petani']);

        $this->actingAs($petani)
            ->from(route('petani.products.create'))
            ->post(route('petani.products.store'), [
                'nama_produk' => 'Kopi@Premium',
                'jumlah' => 10,
                'lokasi' => 'Aceh',
            ])
            ->assertRedirect(route('petani.products.create'))
            ->assertSessionHasErrors(['nama_produk']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_store_accepts_valid_product_data(): void
    {
        $petani = User::factory()->create(['role' => 'petani']);

        $this->actingAs($petani)
            ->post(route('petani.products.store'), [
                'nama_produk' => 'Kopi Arabika',
                'jumlah' => 100,
                'lokasi' => 'Aceh',
            ])
            ->assertRedirect(route('petani.products.index'));

        $this->assertDatabaseHas('products', [
            'user_id' => $petani->id,
            'nama_produk' => 'Kopi Arabika',
            'jumlah' => 100,
            'lokasi' => 'Aceh',
        ]);
    }

    public function test_update_rejects_invalid_data_for_owner(): void
    {
        $petani = User::factory()->create(['role' => 'petani']);
        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'nama_produk' => 'Kopi Arabika',
            'jumlah' => 50,
            'lokasi' => 'Aceh',
        ]);

        $this->actingAs($petani)
            ->from(route('petani.products.edit', $product))
            ->patch(route('petani.products.update', $product), [
                'nama_produk' => 'X',
                'jumlah' => -1,
                'lokasi' => 'AB',
            ])
            ->assertRedirect(route('petani.products.edit', $product))
            ->assertSessionHasErrors(['nama_produk', 'jumlah', 'lokasi']);

        $product->refresh();
        $this->assertSame('Kopi Arabika', $product->nama_produk);
        $this->assertSame(50, $product->jumlah);
        $this->assertSame('Aceh', $product->lokasi);
    }

    public function test_petani_cannot_update_another_users_product(): void
    {
        $owner = User::factory()->create(['role' => 'petani']);
        $other = User::factory()->create(['role' => 'petani']);
        $product = Product::factory()->create([
            'user_id' => $owner->id,
            'nama_produk' => 'Kopi Arabika',
            'jumlah' => 50,
            'lokasi' => 'Aceh',
        ]);

        $this->actingAs($other)
            ->patch(route('petani.products.update', $product), [
                'nama_produk' => 'Kopi Curian',
                'jumlah' => 10,
                'lokasi' => 'Jakarta',
            ])
            ->assertForbidden();

        $product->refresh();
        $this->assertSame('Kopi Arabika', $product->nama_produk);
    }
}
