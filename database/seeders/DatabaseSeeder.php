<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Partnership;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\SystemNotification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
        ]);

        // 1. Seed Subscription Plans
        $planFree = SubscriptionPlan::create([
            'name' => 'Free',
            'price' => 0,
            'duration_days' => 0,
            'description' => 'Paket dasar gratis untuk perdagangan skala kecil',
            'features' => ['basic search', 'basic partnership'],
        ]);

        $planPremium = SubscriptionPlan::create([
            'name' => 'Premium',
            'price' => 50000,
            'duration_days' => 30,
            'description' => 'Akses premium untuk kemitraan skala ekspor terpercaya',
            'features' => ['unlimited partnership', 'advanced exporter insights', 'premium badge', 'priority listing'],
        ]);

        // 2. Admin
        $admin = User::create([
            'name' => 'Admin Exportani',
            'email' => 'admin@exportani.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 3. Farmer (Petani)
        $farmer = User::create([
            'name' => 'Budi Petani',
            'email' => 'petani@exportani.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
            'is_trusted_petani' => true,
            'account_tier' => 'premium',
            'premium_expires_at' => now()->addDays(30),
        ]);

        // Active subscription for Budi Petani
        Subscription::create([
            'user_id' => $farmer->id,
            'plan_id' => $planPremium->id,
            'transaction_id' => 'SUB-DEMO-BUDI-123',
            'payment_type' => 'qris',
            'gross_amount' => 50000,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'paid_at' => now(),
        ]);

        // 4. Exporter (Eksportir)
        $exporter = User::create([
            'name' => 'PT Export Indo',
            'email' => 'eksportir@exportani.com',
            'password' => Hash::make('password'),
            'role' => 'eksportir',
            'account_tier' => 'free',
        ]);

        // Pending subscription for PT Export Indo (to demo admin/payment monitoring)
        Subscription::create([
            'user_id' => $exporter->id,
            'plan_id' => $planPremium->id,
            'transaction_id' => 'SUB-DEMO-PTINDO-456',
            'payment_type' => 'gopay',
            'gross_amount' => 50000,
            'status' => 'pending',
            'start_date' => null,
            'end_date' => null,
            'paid_at' => null,
        ]);

        // 5. Another Farmer with Expired Subscription
        $expiredFarmer = User::create([
            'name' => 'Joko Petani (Expired)',
            'email' => 'expired@exportani.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
            'account_tier' => 'free', // degraded back to free
            'premium_expires_at' => now()->subDays(5),
        ]);

        Subscription::create([
            'user_id' => $expiredFarmer->id,
            'plan_id' => $planPremium->id,
            'transaction_id' => 'SUB-DEMO-JOKO-789',
            'payment_type' => 'bank_transfer',
            'gross_amount' => 50000,
            'status' => 'expired',
            'start_date' => now()->subDays(35),
            'end_date' => now()->subDays(5),
            'paid_at' => now()->subDays(35),
        ]);

        // 6. Another Farmer with Failed Subscription
        $rejectedFarmer = User::create([
            'name' => 'Adi Petani (Failed)',
            'email' => 'failed@exportani.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
            'account_tier' => 'free',
        ]);

        Subscription::create([
            'user_id' => $rejectedFarmer->id,
            'plan_id' => $planPremium->id,
            'transaction_id' => 'SUB-DEMO-ADI-000',
            'payment_type' => 'qris',
            'gross_amount' => 50000,
            'status' => 'failed',
            'start_date' => null,
            'end_date' => null,
            'paid_at' => null,
        ]);

        // 7. Products
        $categories = Category::all();
        $product1 = Product::create([
            'user_id' => $farmer->id,
            'kategori_id' => $categories->firstWhere('slug', 'kopi')->id ?? 1,
            'nama_produk' => 'Kopi Arabica Gayo',
            'deskripsi' => 'Kopi Arabica kualitas ekspor dari Aceh Tengah.',
            'harga' => 150000,
            'jumlah' => 1000,
            'lokasi' => 'Kab. Aceh Tengah',
            'gambar' => null,
            'is_recommended' => true,
            'recommended_at' => now(),
        ]);

        $product2 = Product::create([
            'user_id' => $farmer->id,
            'kategori_id' => $categories->firstWhere('slug', 'rempah-rempah')->id ?? 2,
            'nama_produk' => 'Cengkeh Kualitas Super',
            'deskripsi' => 'Cengkeh kering kualitas tinggi untuk kebutuhan industri.',
            'harga' => 120000,
            'jumlah' => 500,
            'lokasi' => 'Kab. Maluku Tengah',
            'gambar' => null,
        ]);

        // 8. Partnerships
        $partnership1 = Partnership::create([
            'product_id' => $product1->id,
            'petani_id' => $farmer->id,
            'eksportir_id' => $exporter->id,
            'status' => 'pending',
        ]);

        $partnership2 = Partnership::create([
            'product_id' => $product2->id,
            'petani_id' => $farmer->id,
            'eksportir_id' => $exporter->id,
            'status' => 'active',
            'workflow_stage' => 'shipping',
            'total_nilai_kontrak' => 120000000,
        ]);

        // 9. Notifications
        SystemNotification::create([
            'user_id' => $farmer->id,
            'title' => 'Permintaan kerja sama baru',
            'message' => 'PT Export Indo mengajukan kerja sama untuk produk Kopi Arabica Gayo.',
            'is_read' => false,
        ]);

        SystemNotification::create([
            'user_id' => $exporter->id,
            'title' => 'Pengajuan diterima',
            'message' => 'Pengajuan kerja sama kamu untuk produk Cengkeh Kualitas Super telah diterima.',
            'is_read' => true,
        ]);
    }
}
