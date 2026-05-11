<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Master;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_review_submission_is_saved_for_moderation(): void
    {
        config([
            'services.telegram.bot_token' => 'test-token',
            'services.telegram.chat_id' => '-100',
        ]);
        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => true]),
        ]);

        $master = Master::query()->create([
            'name' => 'Олеся',
            'slug' => 'olesya',
            'is_active' => true,
        ]);

        $response = $this->post(route('reviews.store'), [
            'client_name' => 'Оксана',
            'master_id' => $master->id,
            'text' => 'Дуже уважний підхід і хороший результат після масажу.',
            'rating' => '4.5',
        ]);

        $response
            ->assertRedirect(route('booking.index') . '#reviews')
            ->assertSessionHas('review_success');

        $review = Review::query()->first();

        $this->assertNotNull($review);
        $this->assertSame('Оксана', $review->client_name);
        $this->assertSame($master->id, $review->master_id);
        $this->assertSame(Review::STATUS_DRAFT, $review->status);
        $this->assertNull($review->published_at);
        $this->assertSame('4.5', $review->rating);

        Http::assertNothingSent();
    }

    public function test_review_rating_accepts_only_half_step_values(): void
    {
        $master = Master::query()->create([
            'name' => 'Олеся',
            'slug' => 'olesya',
            'is_active' => true,
        ]);

        $response = $this->post(route('reviews.store'), [
            'client_name' => 'Оксана',
            'master_id' => $master->id,
            'text' => 'Дуже уважний підхід і хороший результат після масажу.',
            'rating' => '4.3',
        ]);

        $response->assertSessionHasErrors('rating', null, 'review');
        $this->assertDatabaseCount('reviews', 0);
    }
}
