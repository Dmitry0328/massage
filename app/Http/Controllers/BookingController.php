<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\BookingSetting;
use App\Models\Master;
use App\Models\MassageService;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingAvailabilityService $availabilityService,
    ) {
    }

    public function index()
    {
        $settings = BookingSetting::current();
        $activeMasters = Master::active()->get();
        $rawServices = MassageService::query()
            ->with('master')
            ->active()
            ->get();
        $fallbackServices = $rawServices->whereNull('master_id')->values();
        $services = $rawServices
            ->when($fallbackServices->isNotEmpty() && $rawServices->whereNotNull('master_id')->isEmpty(), function ($collection) use ($activeMasters, $fallbackServices) {
                return $activeMasters->flatMap(function (Master $master) use ($fallbackServices) {
                    return $fallbackServices->map(function (MassageService $service) use ($master): MassageService {
                        $service = clone $service;
                        $service->master_id = $master->id;
                        $service->setRelation('master', $master);

                        return $service;
                    });
                });
            })
            ->map(fn (MassageService $service): array => $service->toBookingArray())
            ->values();
        $servicesByMaster = $services
            ->filter(fn (array $service): bool => ! empty($service['master_id']))
            ->groupBy('master_id');
        $serviceCards = $this->serviceCards($services);
        $priceServicesByMaster = $this->priceServicesByMaster($services);
        $maxDate = $this->maxBookingDate((int) $settings->max_advance_months);

        return view('welcome', [
            'masters' => $activeMasters,
            'services' => $services,
            'serviceCards' => $serviceCards,
            'servicesByMaster' => $servicesByMaster,
            'priceServicesByMaster' => $priceServicesByMaster,
            'mastersForUi' => $activeMasters
                ->map(fn (Master $master): array => [
                    'id' => (string) $master->id,
                    'name' => $master->name,
                ])
                ->values(),
            'serviceOptions' => MassageService::options(),
            'bookingConfig' => [
                'minDate' => now()->toDateString(),
                'maxDate' => $maxDate->toDateString(),
                'maxAdvanceMonths' => $settings->max_advance_months,
                'slots' => $settings->slots(),
                'scheduleLabel' => $settings->scheduleLabel(),
            ],
        ]);
    }

    public function calendar(Request $request): JsonResponse
    {
        $data = $request->validate([
            'master_id' => ['required', 'integer', Rule::exists('masters', 'id')->where('is_active', true)],
            'month' => ['required', 'date_format:Y-m'],
            'service' => ['nullable', Rule::in(MassageService::activeKeys($request->input('master_id')))],
            'apparatus_duration_minutes' => ['nullable', 'integer', Rule::in([15, 30, 45, 60])],
            'additional_services' => ['nullable', 'array'],
            'additional_services.*' => [Rule::in(MassageService::activeKeys($request->input('master_id')))],
        ]);

        $settings = BookingSetting::current();
        $today = now()->startOfDay();
        $maxDate = $this->maxBookingDate((int) $settings->max_advance_months);
        $monthStart = Carbon::createFromFormat('Y-m', $data['month'], config('app.timezone'))->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        abort_if($monthStart->lt($today->copy()->startOfMonth()) || $monthStart->gt($maxDate->copy()->startOfMonth()), 422);

        $master = Master::query()->findOrFail($data['master_id']);
        $serviceKeys = $this->selectedServiceKeys($data['service'] ?? null, $data['additional_services'] ?? []);
        $durationOverrides = $this->durationOverrides($data['service'] ?? null, $data['apparatus_duration_minutes'] ?? null);

        return response()->json([
            'days' => $this->availabilityService->availableDays($master, $monthStart, $monthEnd, $today, $maxDate, $serviceKeys, $durationOverrides),
        ]);
    }

    public function availability(Request $request): JsonResponse
    {
        $data = $request->validate([
            'master_id' => ['required', 'integer', Rule::exists('masters', 'id')->where('is_active', true)],
            'date' => ['required', 'date'],
            'time' => ['nullable', 'date_format:H:i'],
            'service' => ['nullable', Rule::in(MassageService::activeKeys($request->input('master_id')))],
            'apparatus_duration_minutes' => ['nullable', 'integer', Rule::in([15, 30, 45, 60])],
            'additional_services' => ['nullable', 'array'],
            'additional_services.*' => [Rule::in(MassageService::activeKeys($request->input('master_id')))],
        ]);

        $master = Master::query()->findOrFail($data['master_id']);
        $serviceKeys = $this->selectedServiceKeys($data['service'] ?? null, $data['additional_services'] ?? []);
        $durationOverrides = $this->durationOverrides($data['service'] ?? null, $data['apparatus_duration_minutes'] ?? null);
        $payload = [
            'slots' => $this->availabilityService->availableSlots($master, $data['date'], $serviceKeys, $durationOverrides),
        ];

        if (! empty($data['time']) && ! empty($data['service'])) {
            $payload['available_additional_services'] = $this->availabilityService->availableAdditionalServices(
                $master,
                $data['date'],
                $data['time'],
                $data['service'],
                $data['additional_services'] ?? [],
                null,
                $durationOverrides,
            );
        }

        return response()->json($payload);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->has('phone')) {
            $request->merge([
                'phone' => preg_replace('/[\s\-\(\)]/', '', (string) $request->input('phone')),
            ]);
        }

        if ($request->has('client_name')) {
            $request->merge([
                'client_name' => trim(preg_replace('/\s+/', ' ', (string) $request->input('client_name'))),
            ]);
        }

        $validated = $request->validate([
            'client_name' => ['required', 'string', 'min:2', 'max:80', 'regex:/^[А-Яа-яЁёІіЇїЄєҐґ\'’ʼ`\-\s]+$/u'],
            'phone' => ['required', 'string', 'regex:/^\+380\d{9}$/'],
            'master_id' => ['required', 'integer', Rule::exists('masters', 'id')->where('is_active', true)],
            'service' => ['required', Rule::in(MassageService::activeKeys($request->input('master_id')))],
            'additional_services' => ['nullable', 'array'],
            'additional_services.*' => [Rule::in(MassageService::activeKeys($request->input('master_id')))],
            'apparatus_duration_minutes' => ['nullable', 'integer', Rule::in([15, 30, 45, 60])],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'social_contact' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
            'apparatus_discuss' => ['nullable', 'boolean'],
        ], [
            'client_name.required' => 'Вкажіть ваше ім’я.',
            'client_name.min' => 'Ім’я має містити щонайменше 2 символи.',
            'client_name.regex' => 'Вкажіть ім’я українською або російською мовою.',
            'phone.required' => 'Вкажіть номер телефону.',
            'phone.regex' => 'Вкажіть номер телефону у форматі +380XXXXXXXXX.',
            'master_id.required' => 'Оберіть майстра.',
            'service.required' => 'Оберіть послугу.',
            'appointment_date.required' => 'Оберіть дату запису.',
            'appointment_time.required' => 'Оберіть вільний час запису.',
            'appointment_time.date_format' => 'Оберіть час у правильному форматі.',
        ]);

        $additionalServices = collect($validated['additional_services'] ?? [])
            ->filter()
            ->reject(fn (string $service): bool => $service === $validated['service'])
            ->unique()
            ->values()
            ->all();

        $master = Master::query()->findOrFail($validated['master_id']);
        $time = $validated['appointment_time'];
        $serviceKeys = $this->selectedServiceKeys($validated['service'], $additionalServices);
        $durationOverrides = $this->durationOverrides($validated['service'], $validated['apparatus_duration_minutes'] ?? null);

        DB::transaction(function () use ($master, $validated, $time, $additionalServices, $serviceKeys, $durationOverrides): void {
            $isAvailable = $this->availabilityService->isAvailable(
                $master,
                $validated['appointment_date'],
                $time,
                $serviceKeys,
                null,
                $durationOverrides,
            );

            if (! $isAvailable) {
                throw ValidationException::withMessages([
                    'appointment_time' => 'Обраний час уже недоступний для такої тривалості запису. Оберіть інший час або залиште запис на одну процедуру.',
                ]);
            }

            $message = $validated['message'] ?? null;

            if (! empty($validated['apparatus_discuss'])) {
                $message = trim(($message ? "{$message}\n\n" : '') . 'Клієнт обрав: обговорити час апаратного масажу з майстром на прийомі. Вікно заброньовано на 60 хв.');
            } elseif ($durationOverrides) {
                $message = trim(($message ? "{$message}\n\n" : '') . 'Тривалість апаратного масажу: ' . reset($durationOverrides) . ' хв.');
            }

            Appointment::query()->create([
                'master_id' => $master->id,
                'client_name' => $validated['client_name'],
                'phone' => $validated['phone'],
                'service' => $validated['service'],
                'additional_service' => $additionalServices[0] ?? null,
                'additional_services' => $additionalServices,
                'service_durations' => $durationOverrides ?: null,
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $time,
                'social_contact' => $validated['social_contact'] ?? null,
                'message' => $message ?: null,
                'status' => Appointment::STATUS_PENDING,
                'source' => 'website',
            ]);
        });

        return redirect()
            ->route('booking.index')
            ->with('booking_success', 'Заявку на запис надіслано. Цей час уже заброньовано в системі.');
    }

    private function selectedServiceKeys(?string $primaryService, array $additionalServices = []): array
    {
        return collect([$primaryService, ...$additionalServices])
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function durationOverrides(?string $primaryService, int|string|null $duration): array
    {
        if (! $primaryService || ! $duration) {
            return [];
        }

        $service = MassageService::query()->where('key', $primaryService)->first();

        if (! $service?->is_price_per_minute) {
            return [];
        }

        return [$primaryService => (int) $duration];
    }

    private function maxBookingDate(int $maxAdvanceMonths): Carbon
    {
        return now(config('app.timezone'))
            ->addMonthsNoOverflow(max($maxAdvanceMonths - 1, 0))
            ->endOfMonth();
    }

    private function serviceCards($services)
    {
        return $services
            ->groupBy(fn (array $service): string => $service['uses_duration_picker']
                ? "{$service['master_id']}|{$service['apparatus_base']}"
                : "service|{$service['key']}")
            ->map(function ($group): array {
                $first = $group->first();

                if (! $first['uses_duration_picker']) {
                    return $first + ['variants' => []];
                }

                $minutePrice = $first['minute_price'] ?? 10;
                $variants = collect([15, 30, 45, 60])
                    ->map(fn (int $duration): array => [
                        'key' => $first['key'],
                        'duration_minutes' => $duration,
                        'price' => $minutePrice * $duration,
                        'duration' => "{$duration} хв",
                    ])
                    ->all();

                return [
                    ...$first,
                    'key' => '',
                    'label' => $first['apparatus_base'],
                    'display_label' => $first['apparatus_base'],
                    'duration' => 'Оберіть час',
                    'price' => $first['minute_price'] ?? 10,
                    'description' => 'Апаратний масаж: 1 хв - ' . ($first['minute_price'] ?? 10) . ' грн.',
                    'variants' => $variants,
                ];
            })
            ->values();
    }

    private function priceServicesByMaster($services)
    {
        return $services
            ->groupBy('master_id')
            ->map(function ($masterServices) {
                $regularServices = $masterServices
                    ->filter(fn (array $service): bool => ! $service['uses_duration_picker'])
                    ->map(fn (array $service): array => $service + [
                        'price_label' => number_format($service['price'], 0, ',', ' ') . ' грн',
                        'duration_label' => $service['duration'],
                        'is_apparatus_group' => false,
                    ]);

                $apparatusServices = $masterServices
                    ->filter(fn (array $service): bool => $service['uses_duration_picker'])
                    ->groupBy('apparatus_base')
                    ->map(fn ($group) => $group->first())
                    ->values();

                if ($apparatusServices->isEmpty()) {
                    return $regularServices->values();
                }

                $firstApparatus = $apparatusServices->first();
                $apparatusSummary = [
                    ...$firstApparatus,
                    'key' => '',
                    'label' => 'Апаратні масажі:',
                    'display_label' => 'Апаратні масажі:',
                    'price_label' => '1 хв - ' . ($firstApparatus['minute_price'] ?? 10) . ' грн',
                    'duration_label' => '',
                    'is_apparatus_group' => true,
                    'apparatus_base' => '',
                    'apparatus_items' => $apparatusServices
                        ->pluck('apparatus_base')
                        ->filter()
                        ->values()
                        ->all(),
                ];

                return $regularServices
                    ->push($apparatusSummary)
                    ->values();
            });
    }
}
