<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Partnership;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\SystemNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private SubscriptionPlan $planFree;
    private SubscriptionPlan $planPremium;
    private User $petani;
    private User $eksportir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\CategorySeeder::class);

        // 1. Setup default subscription plans
        $this->planFree = SubscriptionPlan::create([
            'name' => 'Free',
            'price' => 0,
            'duration_days' => 0,
            'description' => 'Paket dasar gratis',
            'features' => ['basic search'],
        ]);

        $this->planPremium = SubscriptionPlan::create([
            'name' => 'Premium',
            'price' => 50000,
            'duration_days' => 30,
            'description' => 'Akses premium skala ekspor terpercaya',
            'features' => ['unlimited partnership', 'premium badge', 'priority listing'],
        ]);

        // 2. Setup user roles
        $this->petani = User::factory()->create([
            'role' => 'petani',
            'account_tier' => 'free',
            'is_trusted_petani' => false,
        ]);

        $this->eksportir = User::factory()->create([
            'role' => 'eksportir',
            'account_tier' => 'free',
        ]);
    }

    public function test_petani_checkout_generates_correct_pending_transaction(): void
    {
        $this->actingAs($this->petani)
            ->get(route('premium.checkout', $this->planPremium->id))
            ->assertStatus(200)
            ->assertSee($this->planPremium->name)
            ->assertSee('50.000');

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $this->petani->id,
            'plan_id' => $this->planPremium->id,
            'status' => 'pending',
            'gross_amount' => 50000,
        ]);
    }

    public function test_trusted_petani_gets_loyalty_discount_at_checkout(): void
    {
        $this->petani->update(['is_trusted_petani' => true]);

        $this->actingAs($this->petani->fresh())
            ->get(route('premium.checkout', $this->planPremium->id))
            ->assertStatus(200)
            ->assertSee('40.000'); // 20% discount on 50.000 plan duration = 30 days is 40.000

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $this->petani->id,
            'plan_id' => $this->planPremium->id,
            'status' => 'pending',
            'gross_amount' => 40000,
        ]);
    }

    public function test_webhook_rejects_invalid_signature(): void
    {
        $subscription = Subscription::create([
            'user_id' => $this->eksportir->id,
            'plan_id' => $this->planPremium->id,
            'transaction_id' => 'SUB-TEST-123',
            'gross_amount' => 50000,
            'status' => 'pending',
        ]);

        $payload = [
            'order_id' => 'SUB-TEST-123',
            'status_code' => '200',
            'gross_amount' => '50000.00',
            'signature_key' => 'invalid-signature-key-1234567890',
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
        ];

        // Webhook callback should fail with 403 on invalid signature
        $this->postJson(route('payment.callback'), $payload)
            ->assertStatus(403);

        $subscription->refresh();
        $this->assertSame('pending', $subscription->status);
    }

    public function test_webhook_callback_settlement_activates_premium_automatically(): void
    {
        $subscription = Subscription::create([
            'user_id' => $this->eksportir->id,
            'plan_id' => $this->planPremium->id,
            'transaction_id' => 'SUB-SUCCESS-123',
            'gross_amount' => 50000.00,
            'status' => 'pending',
        ]);

        $serverKey = config('midtrans.server_key', 'SB-Mid-server-dummyKey123');
        $signatureKey = hash("sha512", 'SUB-SUCCESS-123' . '200' . '50000.00' . $serverKey);

        $payload = [
            'order_id' => 'SUB-SUCCESS-123',
            'status_code' => '200',
            'gross_amount' => '50000.00',
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
        ];

        $this->postJson(route('payment.callback'), $payload)
            ->assertStatus(200);

        $subscription->refresh();
        $this->assertSame('active', $subscription->status);
        $this->assertSame('qris', $subscription->payment_type);
        $this->assertNotNull($subscription->paid_at);
        $this->assertNotNull($subscription->end_date);

        $this->eksportir->refresh();
        $this->assertSame('premium', $this->eksportir->account_tier);
        $this->assertTrue($this->eksportir->hasPremiumAccess());

        $this->assertDatabaseHas('system_notifications', [
            'user_id' => $this->eksportir->id,
            'title' => 'Pembayaran Premium Berhasil!',
        ]);
    }

    public function test_webhook_callback_cancel_marks_transaction_cancelled(): void
    {
        $subscription = Subscription::create([
            'user_id' => $this->eksportir->id,
            'plan_id' => $this->planPremium->id,
            'transaction_id' => 'SUB-CANCEL-123',
            'gross_amount' => 50000.00,
            'status' => 'pending',
        ]);

        $serverKey = config('midtrans.server_key', 'SB-Mid-server-dummyKey123');
        $signatureKey = hash("sha512", 'SUB-CANCEL-123' . '200' . '50000.00' . $serverKey);

        $payload = [
            'order_id' => 'SUB-CANCEL-123',
            'status_code' => '200',
            'gross_amount' => '50000.00',
            'signature_key' => $signatureKey,
            'transaction_status' => 'cancel',
            'payment_type' => 'qris',
        ];

        $this->postJson(route('payment.callback'), $payload)
            ->assertStatus(200);

        $subscription->refresh();
        $this->assertSame('cancelled', $subscription->status);

        $this->eksportir->refresh();
        $this->assertSame('free', $this->eksportir->account_tier);
    }

    public function test_free_eksportir_limited_to_five_partnership_requests_per_month(): void
    {
        $category = Category::first();

        // Generate 5 active partnerships in this month for our eksportir
        for ($i = 0; $i < 5; $i++) {
            $seller = User::factory()->create(['role' => 'petani']);
            $product = Product::factory()->create([
                'user_id' => $seller->id,
                'kategori_id' => $category->id,
            ]);
            Partnership::create([
                'product_id' => $product->id,
                'petani_id' => $seller->id,
                'eksportir_id' => $this->eksportir->id,
                'status' => 'active',
                'created_at' => now(),
            ]);
        }

        // Eksportir tries to apply for 6th partnership this month
        $newSeller = User::factory()->create(['role' => 'petani']);
        $newProduct = Product::factory()->create([
            'user_id' => $newSeller->id,
            'kategori_id' => $category->id,
        ]);

        $this->actingAs($this->eksportir)
            ->post(route('partnerships.apply', $newProduct))
            ->assertRedirect(route('premium.index'))
            ->assertSessionHas('error');
    }

    public function test_premium_eksportir_can_make_unlimited_partnership_requests(): void
    {
        $category = Category::first();
        $this->eksportir->update([
            'account_tier' => 'premium',
            'premium_expires_at' => now()->addDays(30),
        ]);

        // Generate 5 existing partnerships
        for ($i = 0; $i < 5; $i++) {
            $seller = User::factory()->create(['role' => 'petani']);
            $product = Product::factory()->create([
                'user_id' => $seller->id,
                'kategori_id' => $category->id,
            ]);
            Partnership::create([
                'product_id' => $product->id,
                'petani_id' => $seller->id,
                'eksportir_id' => $this->eksportir->id,
                'status' => 'active',
                'created_at' => now(),
            ]);
        }

        $newSeller = User::factory()->create(['role' => 'petani']);
        $newProduct = Product::factory()->create([
            'user_id' => $newSeller->id,
            'kategori_id' => $category->id,
        ]);

        $this->actingAs($this->eksportir)
            ->post(route('partnerships.apply', $newProduct))
            ->assertRedirect(); // success redirect to history or details instead of premium page

        $this->assertDatabaseHas('partnerships', [
            'eksportir_id' => $this->eksportir->id,
            'product_id' => $newProduct->id,
        ]);
    }

    public function test_free_petani_limited_to_five_products(): void
    {
        $category = Category::first();

        // Create 5 existing products for the petani
        Product::factory()->count(5)->create([
            'user_id' => $this->petani->id,
            'kategori_id' => $category->id,
        ]);

        $this->actingAs($this->petani)
            ->post(route('petani.products.store'), [
                'nama_produk' => 'Kopi Arabika',
                'deskripsi' => 'Kopi Arabika premium',
                'kategori_id' => $category->id,
                'harga' => 120000,
                'jumlah' => 100,
                'satuan' => 'kg',
                'lokasi' => 'Kab. Aceh Tengah',
                'gambar' => [\Illuminate\Http\UploadedFile::fake()->image('kopi.jpg')],
            ])
            ->assertRedirect(route('premium.upgrade'))
            ->assertSessionHas('error'); // Batas upload free tercapai
    }

    public function test_premium_petani_can_upload_unlimited_products(): void
    {
        $category = Category::first();
        $this->petani->update([
            'account_tier' => 'premium',
            'premium_expires_at' => now()->addDays(30),
        ]);

        // Create 5 existing products
        Product::factory()->count(5)->create([
            'user_id' => $this->petani->id,
            'kategori_id' => $category->id,
        ]);

        $this->actingAs($this->petani)
            ->post(route('petani.products.store'), [
                'nama_produk' => 'Kopi Arabika Baru',
                'deskripsi' => 'Kopi Arabika premium baru',
                'kategori_id' => $category->id,
                'harga' => 120000,
                'jumlah' => 100,
                'satuan' => 'kg',
                'lokasi' => 'Kab. Aceh Tengah',
                'gambar' => [\Illuminate\Http\UploadedFile::fake()->image('kopi.jpg')],
            ])
            ->assertRedirect(route('petani.products.index'))
            ->assertSessionMissing('error'); // should not have limitation error

        $this->assertDatabaseHas('products', [
            'user_id' => $this->petani->fresh()->id,
            'nama_produk' => 'Kopi Arabika Baru',
        ]);
    }

    public function test_premium_expires_gracefully_degrades_user_tier(): void
    {
        // Mock a user whose premium expired in the user cache
        $this->petani->update([
            'account_tier' => 'premium',
            'premium_expires_at' => now()->subMinutes(1),
        ]);

        $this->assertFalse($this->petani->hasPremiumAccess());
    }

    public function test_simulate_payment_successfully_activates_subscription_via_web_route(): void
    {
        $subscription = Subscription::create([
            'user_id' => $this->eksportir->id,
            'plan_id' => $this->planPremium->id,
            'transaction_id' => 'SUB-SIMULATE-123',
            'gross_amount' => 50000.00,
            'status' => 'pending',
        ]);

        $this->actingAs($this->eksportir)
            ->post(route('premium.simulate-payment'), [
                'transaction_id' => 'SUB-SIMULATE-123',
                'status' => 'success',
                'payment_type' => 'gopay',
            ])
            ->assertRedirect(route('premium.index'))
            ->assertSessionHas('success');

        $subscription->refresh();
        $this->assertSame('active', $subscription->status);
        $this->eksportir->refresh();
        $this->assertSame('premium', $this->eksportir->account_tier);
    }
}
