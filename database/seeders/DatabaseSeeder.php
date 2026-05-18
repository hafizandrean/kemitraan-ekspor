<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Partnership;
use App\Models\Product;
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

        // 1. Admin
        User::create([
            'name' => 'Admin Exportani',
            'email' => 'admin@exportani.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Farmer (Petani)
        $farmer = User::create([
            'name' => 'Budi Petani',
            'email' => 'petani@exportani.com',
            'password' => Hash::make('password'),
            'role' => 'farmer',
        ]);

        // 3. Exporter (Eksportir)
        $exporter = User::create([
            'name' => 'PT Export Indo',
            'email' => 'eksportir@exportani.com',
            'password' => Hash::make('password'),
            'role' => 'exporter',
        ]);

        // 4. Products
        $categories = Category::all();
        $product1 = Product::create([
            'user_id' => $farmer->id,
            'kategori_id' => $categories->firstWhere('slug', 'kopi')->id ?? 1,
            'nama_produk' => 'Kopi Arabica Gayo',
            'deskripsi' => 'Kopi Arabica kualitas ekspor dari Aceh Tengah.',
            'harga' => 150000,
            'jumlah' => 1000,
            'lokasi' => 'Aceh Tengah',
            'gambar' => null,
        ]);

        $product2 = Product::create([
            'user_id' => $farmer->id,
            'kategori_id' => $categories->firstWhere('slug', 'rempah-rempah')->id ?? 2,
            'nama_produk' => 'Cengkeh Kualitas Super',
            'deskripsi' => 'Cengkeh kering kualitas tinggi untuk kebutuhan industri.',
            'harga' => 120000,
            'jumlah' => 500,
            'lokasi' => 'Maluku',
            'gambar' => null,
        ]);

        // 5. Partnerships
        $partnership1 = Partnership::create([
            'product_id' => $product1->id,
            'farmer_id' => $farmer->id,
            'exporter_id' => $exporter->id,
            'status' => 'pending',
        ]);

        $partnership2 = Partnership::create([
            'product_id' => $product2->id,
            'farmer_id' => $farmer->id,
            'exporter_id' => $exporter->id,
            'status' => 'accepted',
        ]);

        // 6. Notifications
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
