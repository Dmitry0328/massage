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

    public function test_admin_home_redirects_to_admin_area_on_mobile(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@massage.local',
        ]);

        $response = $this
            ->actingAs($admin)
            ->withHeader('User-Agent', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Mobile/15E148')
            ->get('/admin');

        $response->assertRedirect('/admin/appointments');
    }
}
