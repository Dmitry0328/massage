<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Master;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_is_saved_and_slot_becomes_unavailable(): void
    {
        $master = Master::query()->create([
            'name' => 'Тестовий майстер',
            'slug' => 'test-master',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $date = now()->addDay()->toDateString();

        $response = $this->post(route('booking.store'), [
            'client_name' => 'Іван',
            'phone' => '+380671112233',
            'master_id' => $master->id,
            'service' => 'classic',
            'additional_services' => ['hardware', 'classic'],
            'appointment_date' => $date,
            'appointment_time' => '10:00',
            'social_contact' => '@ivan',
            'message' => 'Тестовий запис',
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHas('booking_success');

        $appointment = Appointment::query()->first();

        $this->assertNotNull($appointment);
        $this->assertSame($master->id, $appointment->master_id);
        $this->assertSame('Іван', $appointment->client_name);
        $this->assertSame('pending', $appointment->status);
        $this->assertSame(['hardware'], $appointment->additional_services);

        $availabilityResponse = $this->getJson(route('booking.availability', [
            'master_id' => $master->id,
            'date' => $date,
            'service' => 'classic',
        ]));

        $availabilityResponse->assertOk();

        $this->assertNotContains('10:00', $availabilityResponse->json('slots'));
        $this->assertNotContains('11:00', $availabilityResponse->json('slots'));
    }

    public function test_duration_blocks_following_slots_and_limits_extra_services(): void
    {
        $master = Master::query()->create([
            'name' => 'Тестовий майстер',
            'slug' => 'test-master-2',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $date = now()->addDay()->toDateString();

        Appointment::query()->create([
            'master_id' => $master->id,
            'client_name' => 'Інший клієнт',
            'phone' => '+380671110000',
            'service' => 'classic',
            'additional_service' => null,
            'additional_services' => [],
            'appointment_date' => $date,
            'appointment_time' => '13:00',
            'status' => Appointment::STATUS_PENDING,
            'source' => 'website',
        ]);

        $availabilityResponse = $this->getJson(route('booking.availability', [
            'master_id' => $master->id,
            'date' => $date,
            'service' => 'classic',
            'additional_services' => ['hardware'],
            'time' => '11:00',
        ]));

        $availabilityResponse->assertOk();
        $this->assertContains('11:00', $availabilityResponse->json('slots'));
        $this->assertSame([], $availabilityResponse->json('available_additional_services'));
    }
}
