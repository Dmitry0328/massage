<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\BookingSetting;
use App\Models\Master;
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
        $services = collect(config('booking.services'))
            ->map(fn (array $service, string $key): array => $service + ['key' => $key])
            ->values();
        $activeMasters = Master::active()->get();
        $maxDate = now()->addMonthsNoOverflow($settings->max_advance_months)->endOfDay();

        return view('welcome', [
            'masters' => $activeMasters,
            'services' => $services,
            'mastersForUi' => $activeMasters
                ->map(fn (Master $master): array => [
                    'id' => (string) $master->id,
                    'name' => $master->name,
                ])
                ->values(),
            'serviceOptions' => collect(config('booking.services'))
                ->mapWithKeys(fn (array $service, string $key): array => [$key => $service['label']])
                ->all(),
            'bookingConfig' => [
                'minDate' => now()->toDateString(),
                'maxDate' => $maxDate->toDateString(),
                'maxAdvanceMonths' => $settings->max_advance_months,
                'slots' => array_values(config('booking.slots')),
            ],
        ]);
    }

    public function calendar(Request $request): JsonResponse
    {
        $data = $request->validate([
            'master_id' => ['required', 'integer', Rule::exists('masters', 'id')->where('is_active', true)],
            'month' => ['required', 'date_format:Y-m'],
            'service' => ['nullable', Rule::in(array_keys(config('booking.services')))],
            'additional_services' => ['nullable', 'array'],
            'additional_services.*' => [Rule::in(array_keys(config('booking.services')))],
        ]);

        $settings = BookingSetting::current();
        $today = now()->startOfDay();
        $maxDate = now()->addMonthsNoOverflow($settings->max_advance_months)->endOfDay();
        $monthStart = Carbon::createFromFormat('Y-m', $data['month'], config('app.timezone'))->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        abort_if($monthStart->lt($today->copy()->startOfMonth()) || $monthStart->gt($maxDate->copy()->startOfMonth()), 422);

        $master = Master::query()->findOrFail($data['master_id']);
        $serviceKeys = $this->selectedServiceKeys($data['service'] ?? null, $data['additional_services'] ?? []);

        return response()->json([
            'days' => $this->availabilityService->availableDays($master, $monthStart, $monthEnd, $today, $maxDate, $serviceKeys),
        ]);
    }

    public function availability(Request $request): JsonResponse
    {
        $data = $request->validate([
            'master_id' => ['required', 'integer', Rule::exists('masters', 'id')->where('is_active', true)],
            'date' => ['required', 'date'],
            'time' => ['nullable', 'date_format:H:i'],
            'service' => ['nullable', Rule::in(array_keys(config('booking.services')))],
            'additional_services' => ['nullable', 'array'],
            'additional_services.*' => [Rule::in(array_keys(config('booking.services')))],
        ]);

        $master = Master::query()->findOrFail($data['master_id']);
        $serviceKeys = $this->selectedServiceKeys($data['service'] ?? null, $data['additional_services'] ?? []);
        $payload = [
            'slots' => $this->availabilityService->availableSlots($master, $data['date'], $serviceKeys),
        ];

        if (! empty($data['time']) && ! empty($data['service'])) {
            $payload['available_additional_services'] = $this->availabilityService->availableAdditionalServices(
                $master,
                $data['date'],
                $data['time'],
                $data['service'],
                $data['additional_services'] ?? [],
            );
        }

        return response()->json($payload);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'master_id' => ['required', 'integer', Rule::exists('masters', 'id')->where('is_active', true)],
            'service' => ['required', Rule::in(array_keys(config('booking.services')))],
            'additional_services' => ['nullable', 'array'],
            'additional_services.*' => [Rule::in(array_keys(config('booking.services')))],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'social_contact' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
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

        DB::transaction(function () use ($master, $validated, $time, $additionalServices, $serviceKeys): void {
            $isAvailable = $this->availabilityService->isAvailable(
                $master,
                $validated['appointment_date'],
                $time,
                $serviceKeys,
            );

            if (! $isAvailable) {
                throw ValidationException::withMessages([
                    'appointment_time' => 'Обраний час уже недоступний для такої тривалості запису. Спробуйте інший слот.',
                ]);
            }

            Appointment::query()->create([
                'master_id' => $master->id,
                'client_name' => $validated['client_name'],
                'phone' => $validated['phone'],
                'service' => $validated['service'],
                'additional_service' => $additionalServices[0] ?? null,
                'additional_services' => $additionalServices,
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $time,
                'social_contact' => $validated['social_contact'] ?? null,
                'message' => $validated['message'] ?? null,
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
}
