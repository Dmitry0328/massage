<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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

    public function test_admin_appointments_page_handles_legacy_single_additional_service(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@massage.local',
        ]);

        $masterId = DB::table('masters')->insertGetId([
            'name' => 'Admin Test Master',
            'slug' => 'admin-test-master',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('appointments')->insert([
            'master_id' => $masterId,
            'client_name' => 'Test Client',
            'phone' => '+380991112233',
            'service' => 'test-service',
            'additional_service' => null,
            'additional_services' => json_encode('serhii-spina-ruchnyy-masazh'),
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '10:00',
            'status' => 'pending',
            'source' => 'website',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get('/admin/appointments');

        $response->assertOk();
    }
}
