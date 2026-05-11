<?php

namespace Tests\Feature;

use App\Models\ContentOverride;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentOverrideTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_and_remove_text_override(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@massage.local',
        ]);

        $response = $this->actingAs($user)->postJson(route('content-overrides.store'), [
            'page_key' => 'home',
            'selector' => 'body > main > section:nth-of-type(1) > h1',
            'type' => 'text',
            'original_hash' => '123',
            'value' => 'Новий текст',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('override.value', 'Новий текст');

        $this->assertDatabaseHas('content_overrides', [
            'page_key' => 'home',
            'type' => 'text',
            'original_hash' => '123',
            'value' => 'Новий текст',
        ]);

        $this->actingAs($user)->deleteJson(route('content-overrides.destroy'), [
            'page_key' => 'home',
            'selector' => 'body > main > section:nth-of-type(1) > h1',
            'type' => 'text',
            'original_hash' => '123',
        ])->assertOk();

        $this->assertSame(0, ContentOverride::query()->count());
    }

    public function test_guest_cannot_save_content_override(): void
    {
        $this->postJson(route('content-overrides.store'), [
            'page_key' => 'home',
            'selector' => 'body > h1',
            'type' => 'text',
            'value' => 'Текст',
        ])->assertUnauthorized();
    }
}
