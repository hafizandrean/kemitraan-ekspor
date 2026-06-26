<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_rejects_invalid_product_data(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
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
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $petani = User::factory()->create(['role' => 'petani']);

        $this->actingAs($petani)
            ->from(route('petani.products.create'))
            ->post(route('petani.products.store'), [
                'nama_produk' => 'Kopi@Premium',
                'jumlah' => 10,
                'lokasi' => 'Kab. Aceh Tengah',
            ])
            ->assertRedirect(route('petani.products.create'))
            ->assertSessionHasErrors(['nama_produk']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_store_accepts_valid_product_data(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $petani = User::factory()->create(['role' => 'petani']);
        $category = \App\Models\Category::first();

        $this->actingAs($petani)
            ->post(route('petani.products.store'), [
                'nama_produk' => 'Kopi Arabika',
                'deskripsi' => 'Kopi Arabika Premium dari Gayo',
                'kategori_id' => $category->id,
                'harga' => 150000,
                'jumlah' => 100,
                'satuan' => 'kg',
                'lokasi' => 'Kab. Aceh Tengah',
                'gambar' => [UploadedFile::fake()->image('kopi.jpg')],
            ])
            ->assertRedirect(route('petani.products.index'));

        $this->assertDatabaseHas('products', [
            'user_id' => $petani->id,
            'nama_produk' => 'Kopi Arabika',
            'jumlah' => 100,
            'lokasi' => 'Kab. Aceh Tengah',
        ]);
    }

    public function test_update_rejects_invalid_data_for_owner(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $petani = User::factory()->create(['role' => 'petani']);
        $category = \App\Models\Category::first();
        $product = Product::factory()->create([
            'user_id' => $petani->id,
            'kategori_id' => $category->id,
            'nama_produk' => 'Kopi Arabika',
            'harga' => 120000,
            'jumlah' => 50,
            'lokasi' => 'Kab. Aceh Tengah',
        ]);

        $this->actingAs($petani)
            ->from(route('petani.products.edit', $product))
            ->patch(route('petani.products.update', $product), [
                'nama_produk' => 'X',
                'deskripsi' => 'Kopi Arabika premium Gayo',
                'kategori_id' => $category->id,
                'harga' => 150000,
                'jumlah' => -1, // will correctly fail because prepareForValidation keeps - sign!
                'satuan' => 'kg',
                'lokasi' => 'AB',
            ])
            ->assertRedirect(route('petani.products.edit', $product))
            ->assertSessionHasErrors(['nama_produk', 'jumlah', 'lokasi']);

        $product->refresh();
        $this->assertSame('Kopi Arabika', $product->nama_produk);
        $this->assertSame(50, $product->jumlah);
    }

    public function test_petani_cannot_update_another_users_product(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $owner = User::factory()->create(['role' => 'petani']);
        $other = User::factory()->create(['role' => 'petani']);
        $category = \App\Models\Category::first();
        $product = Product::factory()->create([
            'user_id' => $owner->id,
            'kategori_id' => $category->id,
            'nama_produk' => 'Kopi Arabika',
            'jumlah' => 50,
            'lokasi' => 'Kab. Aceh Tengah',
        ]);

        $this->actingAs($other)
            ->patch(route('petani.products.update', $product), [
                'nama_produk' => 'Kopi Curian',
                'deskripsi' => 'Maling kopi',
                'kategori_id' => $category->id,
                'harga' => 100,
                'jumlah' => 10,
                'satuan' => 'kg',
                'lokasi' => 'Kota Medan',
            ])
            ->assertForbidden();

        $product->refresh();
        $this->assertSame('Kopi Arabika', $product->nama_produk);
    }
}
