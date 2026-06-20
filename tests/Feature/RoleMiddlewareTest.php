<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_eksportir_cannot_access_petani_crud_endpoints(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $eksportir = User::factory()->create(['role' => 'eksportir']);

        $this->actingAs($eksportir)
            ->get(route('petani.products.create'))
            ->assertForbidden();

        $this->actingAs($eksportir)
            ->get(route('petani.products.index'))
            ->assertForbidden();
    }

    public function test_petani_cannot_access_admin_endpoints(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $petani = User::factory()->create(['role' => 'petani']);

        $this->actingAs($petani)
            ->get(route('admin.categories.index'))
            ->assertForbidden();

        $this->actingAs($petani)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_endpoints(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.categories.index'))
            ->assertOk();
    }
}
