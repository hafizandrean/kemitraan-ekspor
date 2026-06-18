<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
<<<<<<< Updated upstream
=======
use App\Models\Report;
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
    public function test_premium_exporter_can_start_chat(): void
=======
    public function test_chat_room_creation_and_messaging_flow(): void
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
        $response = $this->actingAs($exporter)
            ->post(route('chat.start'), [
                'farmer_id' => $farmer->id,
                'product_id' => $product->id,
            ]);

        $response->assertRedirect();
        
=======
        // Exporter starts conversation
        $this->actingAs($exporter)
            ->post(route('chat.start'), [
                'farmer_id' => $farmer->id,
                'product_id' => $product->id,
            ])
            ->assertRedirect();

>>>>>>> Stashed changes
        $conversation = Conversation::first();
        $this->assertNotNull($conversation);
        $this->assertEquals($farmer->id, $conversation->farmer_id);
        $this->assertEquals($exporter->id, $conversation->exporter_id);
<<<<<<< Updated upstream
    }

    public function test_free_exporter_cannot_start_chat_and_is_redirected(): void
    {
        $farmer = User::factory()->create(['role' => 'petani']);
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'free']);
        
        $product = Product::factory()->create([
            'user_id' => $farmer->id,
            'kategori_id' => \App\Models\Category::first()->id,
            'nama_produk' => 'Kopi Arabika',
=======
        $this->assertEquals($product->id, $conversation->product_id);

        // Exporter sends message
        $this->actingAs($exporter)
            ->post(route('chat.store', $conversation), [
                'message' => 'Halo Pak, apakah stok kopi Arabika tersedia?',
            ])
            ->assertRedirect(route('chat.show', $conversation));

        $message = Message::orderBy('id', 'desc')->first();
        $this->assertNotNull($message);
        $this->assertEquals('Halo Pak, apakah stok kopi Arabika tersedia?', $message->message);
        $this->assertEquals($exporter->id, $message->sender_id);
        $this->assertFalse($message->is_read);

        // Farmer views chat and message is marked as read
        $this->actingAs($farmer)
            ->get(route('chat.show', $conversation))
            ->assertStatus(200)
            ->assertSee('Halo Pak, apakah stok kopi Arabika tersedia?');

        $message->refresh();
        $this->assertTrue($message->is_read);
    }

    public function test_free_exporter_limited_to_one_conversation(): void
    {
        $farmer1 = User::factory()->create(['role' => 'petani']);
        $farmer2 = User::factory()->create(['role' => 'petani']);
        
        // Free exporter
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'free']);

        $product1 = Product::factory()->create([
            'user_id' => $farmer1->id,
            'kategori_id' => \App\Models\Category::first()->id,
            'nama_produk' => 'Kopi',
>>>>>>> Stashed changes
            'jumlah' => 10,
            'lokasi' => 'Kab. Gayo',
        ]);

<<<<<<< Updated upstream
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
=======
        $product2 = Product::factory()->create([
            'user_id' => $farmer2->id,
            'kategori_id' => \App\Models\Category::first()->id,
            'nama_produk' => 'Kakao',
            'jumlah' => 10,
            'lokasi' => 'Kab. Tabanan',
        ]);

        // First chat starts successfully
        $this->actingAs($exporter)
            ->post(route('chat.start'), [
                'farmer_id' => $farmer1->id,
                'product_id' => $product1->id,
            ])
            ->assertRedirect();

        $this->assertEquals(1, Conversation::count());

        // Second chat start gets redirected to premium upgrade because of limits
        $this->actingAs($exporter)
            ->post(route('chat.start'), [
                'farmer_id' => $farmer2->id,
                'product_id' => $product2->id,
            ])
            ->assertRedirect(route('premium.upgrade'));

        $this->assertEquals(1, Conversation::count());

        // If the exporter upgrades to Premium
        $exporter->update(['account_tier' => 'premium']);

        // Now second chat works fine
        $this->actingAs($exporter)
            ->post(route('chat.start'), [
                'farmer_id' => $farmer2->id,
                'product_id' => $product2->id,
            ])
            ->assertRedirect();

        $this->assertEquals(2, Conversation::count());
    }

    public function test_unauthorized_user_cannot_access_conversation(): void
    {
        $farmer = User::factory()->create(['role' => 'petani']);
        $exporter = User::factory()->create(['role' => 'eksportir', 'account_tier' => 'premium']);
        $thirdUser = User::factory()->create(['role' => 'eksportir']);

        $conversation = Conversation::create([
            'farmer_id' => $farmer->id,
            'exporter_id' => $exporter->id,
        ]);

        // Third user tries to view conversation and gets 403
        $this->actingAs($thirdUser)
            ->get(route('chat.show', $conversation))
            ->assertStatus(403);

        // Third user tries to post message and gets 403
        $this->actingAs($thirdUser)
            ->post(route('chat.store', $conversation), [
                'message' => 'Penyusup',
            ])
            ->assertStatus(403);
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

        // Admin resolves report and suspends the exporter
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
>>>>>>> Stashed changes
