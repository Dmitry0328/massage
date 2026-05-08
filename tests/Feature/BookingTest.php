<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\BookingSetting;
use App\Models\ClientRequest;
use App\Models\Master;
use App\Models\MassageService;
use App\Models\ScheduleBlock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_is_saved_and_slot_becomes_unavailable(): void
    {
        config([
            'services.telegram.bot_token' => 'test-token',
            'services.telegram.chat_id' => '-100',
        ]);
        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => true]),
        ]);

        $master = Master::query()->create([
            'name' => 'Тестовий майстер',
            'slug' => 'test-master',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $date = $this->nextWorkingDate();

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

        Http::assertSent(fn ($request): bool => str_contains($request->url(), '/bottest-token/sendMessage')
            && $request['chat_id'] === '-100'
            && str_contains($request['text'], 'Новий запис на масаж'));
    }

    public function test_duration_blocks_following_slots_and_limits_extra_services(): void
    {
        $master = Master::query()->create([
            'name' => 'Тестовий майстер',
            'slug' => 'test-master-2',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $date = $this->nextWorkingDate();

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

    public function test_appointment_blocks_slot_for_other_masters(): void
    {
        $firstMaster = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-availability-block',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $secondMaster = Master::query()->create([
            'name' => 'Serhii',
            'slug' => 'serhii-availability-block',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $date = now()->addDay()->toDateString();

        Appointment::query()->create([
            'master_id' => $firstMaster->id,
            'client_name' => 'Клієнт',
            'phone' => '+380671110001',
            'service' => 'classic',
            'additional_service' => 'hardware',
            'additional_services' => ['hardware'],
            'appointment_date' => $date,
            'appointment_time' => '14:00',
            'status' => Appointment::STATUS_PENDING,
            'source' => 'website',
        ]);

        $availabilityResponse = $this->getJson(route('booking.availability', [
            'master_id' => $secondMaster->id,
            'date' => $date,
            'service' => 'classic',
        ]));

        $availabilityResponse->assertOk();
        $this->assertNotContains('14:00', $availabilityResponse->json('slots'));
        $this->assertNotContains('15:00', $availabilityResponse->json('slots'));
    }

    public function test_missing_time_uses_human_readable_validation_message(): void
    {
        $master = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-validation',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->from(route('booking.index'))->post(route('booking.store'), [
            'client_name' => 'Клієнт',
            'phone' => '+380671110002',
            'master_id' => $master->id,
            'service' => 'classic',
            'appointment_date' => $this->nextWorkingDate(),
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHasErrors([
                'appointment_time' => 'Оберіть вільний час запису.',
            ]);
    }

    public function test_contact_fields_require_cyrillic_name_and_ukrainian_phone(): void
    {
        $master = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-contact-validation',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->from(route('booking.index'))->post(route('booking.store'), [
            'client_name' => 'John',
            'phone' => '+3806711100029',
            'master_id' => $master->id,
            'service' => 'classic',
            'appointment_date' => $this->nextWorkingDate(),
            'appointment_time' => '10:00',
            'social_contact' => '@maria',
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHasErrors(['client_name', 'phone']);

        $this->assertSame(0, Appointment::query()->count());
    }

    public function test_phone_is_normalized_before_validation(): void
    {
        $master = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-phone-normalized',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->from(route('booking.index'))->post(route('booking.store'), [
            'client_name' => 'Марія',
            'phone' => '+380 67 111 00 22',
            'master_id' => $master->id,
            'service' => 'classic',
            'appointment_date' => $this->nextWorkingDate(),
            'appointment_time' => '10:00',
            'social_contact' => '@maria',
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHas('booking_success');

        $this->assertSame('+380671110022', Appointment::query()->value('phone'));
    }

    public function test_store_rejects_occupied_slot_for_other_master(): void
    {
        $firstMaster = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-store',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $secondMaster = Master::query()->create([
            'name' => 'Serhii',
            'slug' => 'serhii-store',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $date = now()->addDay()->toDateString();

        Appointment::query()->create([
            'master_id' => $firstMaster->id,
            'client_name' => 'Існуючий Клієнт',
            'phone' => '+380671110003',
            'service' => 'classic',
            'additional_service' => null,
            'additional_services' => [],
            'appointment_date' => $date,
            'appointment_time' => '11:00',
            'status' => Appointment::STATUS_PENDING,
            'source' => 'website',
        ]);

        $response = $this->from(route('booking.index'))->post(route('booking.store'), [
            'client_name' => 'Новий Клієнт',
            'phone' => '+380671110004',
            'master_id' => $secondMaster->id,
            'service' => 'classic',
            'appointment_date' => $date,
            'appointment_time' => '11:00',
            'social_contact' => '@client',
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHasErrors('appointment_time');

        $this->assertSame(1, Appointment::query()->count());
    }

    public function test_calendar_marks_day_unavailable_when_all_salon_slots_are_occupied(): void
    {
        $firstMaster = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-full-day',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $secondMaster = Master::query()->create([
            'name' => 'Serhii',
            'slug' => 'serhii-full-day',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $date = now()->addDay();

        foreach (config('booking.slots') as $slot) {
            Appointment::query()->create([
                'master_id' => $firstMaster->id,
                'client_name' => "Client {$slot}",
                'phone' => '+380671110005',
                'service' => 'classic',
                'additional_service' => null,
                'additional_services' => [],
                'appointment_date' => $date->toDateString(),
                'appointment_time' => $slot,
                'status' => Appointment::STATUS_PENDING,
                'source' => 'website',
            ]);
        }

        $response = $this->getJson(route('booking.calendar', [
            'master_id' => $secondMaster->id,
            'month' => $date->format('Y-m'),
            'service' => 'classic',
        ]));

        $response->assertOk();

        $day = collect($response->json('days'))->firstWhere('date', $date->toDateString());
        $this->assertNotNull($day);
        $this->assertFalse($day['available']);
        $this->assertSame(0, $day['slots_count']);
    }

    public function test_salon_block_hides_slot_for_all_masters(): void
    {
        $master = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-block',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $date = now()->addDay()->toDateString();

        ScheduleBlock::query()->create([
            'master_id' => null,
            'block_date' => $date,
            'is_full_day' => false,
            'start_time' => '12:00',
            'end_time' => '13:00',
            'note' => 'Test block',
        ]);

        $response = $this->getJson(route('booking.availability', [
            'master_id' => $master->id,
            'date' => $date,
            'service' => 'classic',
        ]));

        $response->assertOk();
        $this->assertNotContains('12:00', $response->json('slots'));
    }

    public function test_one_month_setting_allows_only_current_calendar_month(): void
    {
        BookingSetting::current()->update([
            'max_advance_months' => 1,
        ]);

        Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-setting',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get(route('booking.index'));

        $response->assertOk();
        $response->assertSee('"maxAdvanceMonths":1', false);
        $response->assertSee('"maxDate":"' . now()->endOfMonth()->toDateString() . '"', false);
    }

    public function test_work_schedule_setting_controls_public_slots(): void
    {
        BookingSetting::current()->update([
            'working_days' => [1, 2, 3, 4, 5, 6, 7],
            'work_start_time' => '09:00',
            'work_end_time' => '11:00',
            'slot_step_minutes' => 30,
        ]);

        $master = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-work-schedule',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $date = now()->addDay()->toDateString();

        $response = $this->getJson(route('booking.availability', [
            'master_id' => $master->id,
            'date' => $date,
            'service' => 'classic',
        ]));

        $response->assertOk();
        $this->assertSame(['09:00', '09:30', '10:00'], $response->json('slots'));
        $this->assertNotContains('11:00', $response->json('slots'));
    }

    public function test_service_must_belong_to_selected_master(): void
    {
        MassageService::query()->delete();

        $firstMaster = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-services',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $secondMaster = Master::query()->create([
            'name' => 'Serhii',
            'slug' => 'serhii-services',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        MassageService::query()->create([
            'master_id' => $firstMaster->id,
            'key' => 'olesia-classic',
            'label' => 'Classic Olesia',
            'duration_minutes' => 60,
            'price' => 500,
            'is_active' => true,
        ]);

        MassageService::query()->create([
            'master_id' => $secondMaster->id,
            'key' => 'serhii-hardware',
            'label' => 'Hardware Serhii',
            'duration_minutes' => 60,
            'price' => 700,
            'is_active' => true,
        ]);

        $this->get(route('booking.index'))
            ->assertOk()
            ->assertSee('"master_id":"' . $firstMaster->id . '"', false)
            ->assertSee('"master_id":"' . $secondMaster->id . '"', false);

        $response = $this->from(route('booking.index'))->post(route('booking.store'), [
            'client_name' => 'Марія',
            'phone' => '+380671110033',
            'master_id' => $firstMaster->id,
            'service' => 'serhii-hardware',
            'appointment_date' => $this->nextWorkingDate(),
            'appointment_time' => '10:00',
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHasErrors('service');

        $this->assertSame(0, Appointment::query()->count());
    }

    public function test_three_apparatus_services_can_be_booked_with_shared_duration(): void
    {
        MassageService::query()->delete();

        $master = Master::query()->create([
            'name' => 'Olesia',
            'slug' => 'olesia-apparatus',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        foreach (['apparatus-one', 'apparatus-two', 'apparatus-three'] as $index => $key) {
            MassageService::query()->create([
                'master_id' => $master->id,
                'key' => $key,
                'label' => 'Apparatus ' . ($index + 1),
                'category' => 'Apparatus',
                'duration_minutes' => 60,
                'price' => 10,
                'is_price_per_minute' => true,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        $response = $this->from(route('booking.index'))->post(route('booking.store'), [
            'client_name' => 'Марія',
            'phone' => '+380671110044',
            'master_id' => $master->id,
            'service' => 'apparatus-one',
            'additional_services' => ['apparatus-two', 'apparatus-three'],
            'apparatus_duration_minutes' => 15,
            'appointment_date' => $this->nextWorkingDate(),
            'appointment_time' => '10:00',
            'social_contact' => '@maria',
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHas('booking_success');

        $appointment = Appointment::query()->first();

        $this->assertSame(['apparatus-two', 'apparatus-three'], $appointment->additional_services);
        $this->assertSame([
            'apparatus-one' => 15,
            'apparatus-two' => 15,
            'apparatus-three' => 15,
        ], $appointment->service_durations);
    }

    public function test_client_request_is_saved_for_admin_follow_up(): void
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
            'slug' => 'olesia-callback',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->from(route('booking.index'))->post(route('client-requests.store'), [
            'client_name' => 'Марія',
            'phone' => '+380 (67) 111-22-33',
            'master_id' => $master->id,
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHas('client_request_success');

        $request = ClientRequest::query()->first();

        $this->assertNotNull($request);
        $this->assertSame($master->id, $request->master_id);
        $this->assertSame('Марія', $request->client_name);
        $this->assertSame('+380671112233', $request->phone);
        $this->assertSame(ClientRequest::STATUS_NEW, $request->status);
        $this->assertStringContainsString('Потрібно зателефонувати', $request->message);

        Http::assertSent(fn ($request): bool => str_contains($request->url(), '/bottest-token/sendMessage')
            && $request['chat_id'] === '-100'
            && str_contains($request['text'], 'Новий запит на зворотний дзвінок'));
    }

    public function test_client_request_rejects_invalid_phone(): void
    {
        $master = Master::query()->create([
            'name' => 'Олеся',
            'slug' => 'olesia-callback-invalid',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->from(route('booking.index'))->post(route('client-requests.store'), [
            'client_name' => 'Марія',
            'phone' => '12345',
            'master_id' => $master->id,
        ]);

        $response
            ->assertRedirect(route('booking.index'))
            ->assertSessionHasErrors('phone', null, 'clientRequest')
            ->assertSessionHas('open_client_request_popup');

        $this->assertSame(0, ClientRequest::query()->count());
    }

    private function nextWorkingDate(): string
    {
        $date = now()->addDay();

        while ((int) $date->isoWeekday() === 7) {
            $date->addDay();
        }

        return $date->toDateString();
    }
}
