<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\Report;
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
        $this->assertEquals($product->id, $conversation->product_id);

        // Assert automated initial message is sent
        $message = Message::first();
        $this->assertNotNull($message);
        $this->assertEquals("Halo Pak, saya tertarik dengan produk Kopi Arabika Anda.", $message->message);
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

    public function test_chat_reporting_and_admin_moderation_flow(): void
    {
        $farmer = User::factory()->create(['role' => 'petani']);
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'premium']);
        $admin = User::factory()->create(['role' => 'admin']);

        $conversation = Conversation::create([
            'farmer_id' => $farmer->id,
            'exporter_id' => $exporter->id,
        ]);

        // Exporter sends offensive message
        $conversation->messages()->create([
            'sender_id' => $exporter->id,
            'message' => 'Ini penipuan!',
        ]);

        // Farmer reports exporter
        $this->actingAs($farmer)
            ->from(route('chat.show', $conversation))
            ->post(route('chat.report'), [
                'reported_user_id' => $exporter->id,
                'conversation_id' => $conversation->id,
                'reason' => 'fraud',
                'description' => 'Eksportir ini menuduh kami melakukan penipuan dan berkata kasar.',
            ])
            ->assertRedirect(route('chat.show', $conversation));

        $report = Report::first();
        $this->assertNotNull($report);
        $this->assertEquals($farmer->id, $report->reporter_id);
        $this->assertEquals($exporter->id, $report->reported_user_id);
        $this->assertEquals('fraud', $report->reason);
        $this->assertEquals('pending', $report->status);

        // Admin checks moderation dashboard
        $this->actingAs($admin)
            ->get(route('admin.chat.dashboard'))
            ->assertStatus(200)
            ->assertSee($exporter->name)
            ->assertSee('fraud');

        // Admin reviews reported chat details
        $this->actingAs($admin)
            ->get(route('admin.chat.report.show', $report))
            ->assertStatus(200)
            ->assertSee('Ini penipuan!')
            ->assertSee('Eksportir ini menuduh kami melakukan penipuan');

        // Admin resolves report
        $this->actingAs($admin)
            ->post(route('admin.chat.report.resolve', $report), [
                'status' => 'resolved',
            ])
            ->assertRedirect(route('admin.chat.dashboard'));

        $report->refresh();
        $this->assertEquals('resolved', $report->status);

        // Admin suspends user
        $this->actingAs($admin)
            ->from(route('admin.chat.report.show', $report))
            ->post(route('admin.users.status.update', $exporter), [
                'status' => 'suspended',
            ])
            ->assertRedirect(route('admin.chat.report.show', $report));

        $exporter->refresh();
        $this->assertEquals('suspended', $exporter->status);
    }

    public function test_suspended_and_banned_user_restrictions(): void
    {
        $farmer = User::factory()->create(['role' => 'petani']);
        $suspendedExporter = User::factory()->create([
            'role' => 'eksportir',
            'status' => 'suspended',
        ]);
        $bannedExporter = User::factory()->create([
            'role' => 'eksportir',
            'status' => 'banned',
        ]);

        $product = Product::factory()->create([
            'user_id' => $farmer->id,
            'kategori_id' => \App\Models\Category::first()->id,
            'nama_produk' => 'Biji Kopi',
            'jumlah' => 100,
            'lokasi' => 'Kab. Gayo',
        ]);

        $conversation = Conversation::create([
            'farmer_id' => $farmer->id,
            'exporter_id' => $suspendedExporter->id,
        ]);

        // Suspended user cannot start a chat
        $this->actingAs($suspendedExporter)
            ->post(route('chat.start'), [
                'farmer_id' => $farmer->id,
                'product_id' => $product->id,
            ])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error');

        // Suspended user cannot send a message
        $this->actingAs($suspendedExporter)
            ->post(route('chat.store', $conversation), [
                'message' => 'Halo Pak',
            ])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error');

        // Suspended user cannot submit a partnership application
        $this->actingAs($suspendedExporter)
            ->post(route('partnerships.apply', $product))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error');

        // Banned user gets logged out and redirected to login page on check
        $this->actingAs($bannedExporter)
            ->get(route('dashboard'))
            ->assertRedirect(route('login'));
        
        $this->assertFalse(\Illuminate\Support\Facades\Auth::check());
    }
}
