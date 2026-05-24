<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_category_recommendation_and_trusted_farmer(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);

        $admin = User::factory()->create(['role' => 'admin']);
        $farmer = User::factory()->create(['role' => 'farmer']);
        $category = Category::first();
        $product = Product::factory()->create([
            'user_id' => $farmer->id,
            'kategori_id' => $category->id,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), ['name' => 'Teh'])
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['name' => 'Teh']);

        $this->actingAs($admin)
            ->post(route('admin.recommendations.toggle', $product))
            ->assertRedirect();

        $product->refresh();
        $this->assertTrue($product->is_recommended);

        $this->actingAs($admin)
            ->post(route('admin.trusted-farmers.toggle', $farmer))
            ->assertRedirect();

        $farmer->refresh();
        $this->assertTrue($farmer->is_trusted_farmer);
    }

    public function test_exporter_can_filter_trusted_and_recommended_products(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);

        $exporter = User::factory()->create(['role' => 'exporter']);
        $trustedFarmer = User::factory()->create(['role' => 'farmer', 'is_trusted_farmer' => true]);
        $category = Category::first();

        Product::factory()->create([
            'user_id' => $trustedFarmer->id,
            'kategori_id' => $category->id,
            'is_recommended' => true,
            'recommended_at' => now(),
        ]);

        $this->actingAs($exporter)
            ->get(route('products.index', ['trusted_only' => 1, 'recommended_only' => 1]))
            ->assertOk()
            ->assertSee('Filter Pencarian');
    }
}
