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
        $farmer = User::factory()->create(['role' => 'petani']);
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
        $this->assertTrue($farmer->is_trusted_petani);
    }

    public function test_exporter_can_filter_trusted_and_recommended_products(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);

        $exporter = User::factory()->create(['role' => 'eksportir']);
        $trustedFarmer = User::factory()->create(['role' => 'petani', 'is_trusted_petani' => true]);
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

    public function test_admin_can_access_chat_moderation_dashboard_and_resolve_report(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);

        $admin = User::factory()->create(['role' => 'admin']);
        $farmer = User::factory()->create(['role' => 'petani']);
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'premium']);
        
        $conversation = \App\Models\Conversation::create([
            'farmer_id' => $farmer->id,
            'exporter_id' => $exporter->id,
            'last_message_at' => now(),
        ]);

        $message = \App\Models\Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $exporter->id,
            'message' => 'Halo, ini pesan mencurigakan.',
        ]);

        $report = \App\Models\Report::create([
            'reporter_id' => $farmer->id,
            'reported_user_id' => $exporter->id,
            'conversation_id' => $conversation->id,
            'reason' => 'fraud',
            'description' => 'Eksportir ini mencoba melakukan penipuan.',
            'status' => 'pending',
        ]);

        // 1. Admin accesses moderation dashboard
        $response = $this->actingAs($admin)
            ->get(route('admin.chat.dashboard'));
        $response->assertOk();
        $response->assertSee('Moderasi Chat');
        $response->assertSee('Eksportir ini mencoba melakukan penipuan.');

        // 2. Admin views report details and transcript
        $response = $this->actingAs($admin)
            ->get(route('admin.chat.report.show', $report));
        $response->assertOk();
        $response->assertSee('Halo, ini pesan mencurigakan.');
        $response->assertSee('Eksportir ini mencoba melakukan penipuan.');

        // 3. Admin resolves the report
        $response = $this->actingAs($admin)
            ->post(route('admin.chat.report.resolve', $report), [
                'action' => 'resolve',
            ]);
        $response->assertRedirect(route('admin.chat.dashboard'));
        $this->assertEquals('resolved', $report->fresh()->status);

        // 4. Admin toggles user status to suspended
        $response = $this->actingAs($admin)
            ->post(route('admin.users.status.update', $exporter), [
                'status' => 'suspended',
            ]);
        $response->assertRedirect();
        $this->assertEquals('suspended', $exporter->fresh()->status);
    }

    public function test_non_admin_cannot_access_chat_moderation(): void
    {
        $exporter = User::factory()->create(['role' => 'eksportir']);

        $response = $this->actingAs($exporter)
            ->get(route('admin.chat.dashboard'));
        
        $response->assertStatus(403);
    }
}

