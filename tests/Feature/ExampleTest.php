<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_root_renders_public_landing_page(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('EXPORTANI');
    }
}
