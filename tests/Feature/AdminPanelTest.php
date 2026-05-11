<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_home_does_not_redirect_to_public_site(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@massage.local',
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertRedirect('/admin/appointments');
    }
}
