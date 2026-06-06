<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(\Database\Seeders\CategorySeeder::class);
        
        // Seed default subscription plans
        \App\Models\SubscriptionPlan::create([
            'name' => 'Free',
            'price' => 0,
            'duration_days' => 0,
            'description' => 'Free plan',
            'features' => ['basic search'],
        ]);
        
        \App\Models\SubscriptionPlan::create([
            'name' => 'Premium',
            'price' => 50000,
            'duration_days' => 30,
            'description' => 'Premium plan',
            'features' => ['unlimited partnership', 'direct_chat'],
        ]);
    }

    public function test_premium_exporter_can_start_chat(): void
    {
        $farmer = User::factory()->create(['role' => 'petani']);
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'premium']);
        
        $product = Product::factory()->create([
            'user_id' => $farmer->id,
            'kategori_id' => \App\Models\Category::first()->id,
            'nama_produk' => 'Kopi Arabika',
            'jumlah' => 10,
            'lokasi' => 'Kab. Gayo',
        ]);

        $response = $this->actingAs($exporter)
            ->post(route('chat.start'), [
                'farmer_id' => $farmer->id,
                'product_id' => $product->id,
            ]);

        $response->assertRedirect();
        
        $conversation = Conversation::first();
        $this->assertNotNull($conversation);
        $this->assertEquals($farmer->id, $conversation->farmer_id);
        $this->assertEquals($exporter->id, $conversation->exporter_id);
    }

    public function test_free_exporter_cannot_start_chat_and_is_redirected(): void
    {
        $farmer = User::factory()->create(['role' => 'petani']);
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'free']);
        
        $product = Product::factory()->create([
            'user_id' => $farmer->id,
            'kategori_id' => \App\Models\Category::first()->id,
            'nama_produk' => 'Kopi Arabika',
            'jumlah' => 10,
            'lokasi' => 'Kab. Gayo',
        ]);

        $response = $this->actingAs($exporter)
            ->post(route('chat.start'), [
                'farmer_id' => $farmer->id,
                'product_id' => $product->id,
            ]);

        $response->assertRedirect(route('premium.index'));
        $this->assertEquals(0, Conversation::count());
    }

    public function test_free_exporter_cannot_access_chat_index(): void
    {
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'free']);

        $response = $this->actingAs($exporter)
            ->get(route('chat.index'));

        $response->assertRedirect(route('premium.index'));
    }

    public function test_farmer_can_receive_and_reply_to_chat(): void
    {
        $farmer = User::factory()->create(['role' => 'petani']);
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'premium']);
        
        $conversation = Conversation::create([
            'farmer_id' => $farmer->id,
            'exporter_id' => $exporter->id,
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($farmer)
            ->post(route('chat.store', $conversation), [
                'message' => 'Halo, ready stok komoditas?',
            ]);

        $response->assertRedirect(route('chat.show', $conversation));
        $this->assertEquals(1, Message::count());
        $this->assertEquals('Halo, ready stok komoditas?', Message::first()->message);
    }

    public function test_unrelated_user_cannot_access_conversation(): void
    {
        $farmer = User::factory()->create(['role' => 'petani']);
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'premium']);
        $otherUser = User::factory()->create(['role' => 'petani']);

        $conversation = Conversation::create([
            'farmer_id' => $farmer->id,
            'exporter_id' => $exporter->id,
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($otherUser)
            ->get(route('chat.show', $conversation));

        $response->assertStatus(403);
    }
}