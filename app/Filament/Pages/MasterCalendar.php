<?php

namespace App\Filament\Pages;

use App\Models\Appointment;
use App\Models\BookingSetting;
use App\Models\Master;
use App\Models\MassageService;
use App\Models\ScheduleBlock;
use App\Services\BookingAvailabilityService;
use BackedEnum;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class MasterCalendar extends Page
{
    protected string $view = 'filament.pages.master-calendar';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Календар майстра';

    protected static ?string $title = 'Календар майстра';

    protected static ?int $navigationSort = 4;

    public string $monthKey = '';

    public ?string $selectedDate = null;

    public int $maxAdvanceMonths = 1;

    public array $workingDays = [];

    public string $workStartTime = '10:00';

    public string $workEndTime = '18:00';

    public int $slotStepMinutes = 60;

    public ?int $selectedAppointmentId = null;

    public function mount(): void
    {
        Carbon::setLocale('uk');

        $setting = BookingSetting::current();

        $this->maxAdvanceMonths = (int) $setting->max_advance_months;
        $this->workingDays = $setting->workingDays();
        $this->workStartTime = substr((string) $setting->work_start_time, 0, 5);
        $this->workEndTime = substr((string) $setting->work_end_time, 0, 5);
        $this->slotStepMinutes = (int) $setting->slot_step_minutes;
        $this->monthKey = now(config('app.timezone'))->format('Y-m');
        $this->selectedDate = now(config('app.timezone'))->toDateString();
    }

    public function previousMonth(): void
    {
        $this->monthKey = $this->monthStart()->subMonthNoOverflow()->format('Y-m');
        $this->selectedDate = $this->firstAvailableDate() ?? $this->monthStart()->toDateString();
    }

    public function nextMonth(): void
    {
        $this->monthKey = $this->monthStart()->addMonthNoOverflow()->format('Y-m');
        $this->selectedDate = $this->firstAvailableDate() ?? $this->monthStart()->toDateString();
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
        $this->selectedAppointmentId = null;
    }

    public function openAppointment(int $appointmentId): void
    {
        $this->selectedAppointmentId = $appointmentId;
    }

    public function closeAppointment(): void
    {
        $this->selectedAppointmentId = null;
    }

    public function blockSelectedDate(): void
    {
        if (! $this->selectedDate) {
            return;
        }

        ScheduleBlock::query()->firstOrCreate([
            'master_id' => null,
            'block_date' => $this->selectedDate,
            'is_full_day' => true,
        ], [
            'note' => 'Блокування всього дня з календаря салону',
        ]);

        Notification::make()
            ->title('День заблоковано для записів')
            ->success()
            ->send();
    }

    public function blockSlot(string $time): void
    {
        if (! $this->selectedDate || $this->appointmentForSlot($time)) {
            return;
        }

        $start = Carbon::parse(sprintf('%s %s', $this->selectedDate, $time), config('app.timezone'));

        ScheduleBlock::query()->firstOrCreate([
            'master_id' => null,
            'block_date' => $this->selectedDate,
            'is_full_day' => false,
            'start_time' => $start->format('H:i'),
            'end_time' => $start->copy()->addMinutes($this->slotStepInMinutes())->format('H:i'),
        ], [
            'note' => 'Блокування часу з календаря салону',
        ]);

        Notification::make()
            ->title("Час {$time} заблоковано")
            ->success()
            ->send();
    }

    public function unblock(int $blockId): void
    {
        ScheduleBlock::query()->whereKey($blockId)->delete();

        Notification::make()
            ->title('Блокування знято')
            ->success()
            ->send();
    }

    public function saveSettings(): void
    {
        $validated = $this->validate([
            'maxAdvanceMonths' => ['required', 'integer', 'min:1', 'max:12'],
            'workingDays' => ['required', 'array', 'min:1'],
            'workingDays.*' => ['integer', 'min:1', 'max:7'],
            'workStartTime' => ['required', 'date_format:H:i'],
            'workEndTime' => ['required', 'date_format:H:i', 'after:workStartTime'],
            'slotStepMinutes' => ['required', 'integer', 'min:15', 'max:240'],
        ]);

        BookingSetting::current()->update([
            'max_advance_months' => $validated['maxAdvanceMonths'],
            'working_days' => array_values(array_map('intval', $validated['workingDays'])),
            'work_start_time' => $validated['workStartTime'],
            'work_end_time' => $validated['workEndTime'],
            'slot_step_minutes' => $validated['slotStepMinutes'],
        ]);

        Notification::make()
            ->title('Налаштування запису збережено')
            ->success()
            ->send();
    }

    public function monthTitle(): string
    {
        return $this->monthStart()->translatedFormat('F Y р.');
    }

    public function calendarDays(): array
    {
        $monthStart = $this->monthStart();
        $monthEnd = $monthStart->copy()->endOfMonth();
        $minDate = now(config('app.timezone'))->startOfDay();
        $maxDate = $this->maxBookingDate();
        $master = $this->previewMaster();

        $defaultServiceKey = $master ? MassageService::activeForMaster($master->id)->first()?->key : null;
        $servicesForPreview = $defaultServiceKey ? [$defaultServiceKey] : [];

        $availability = $master
            ? app(BookingAvailabilityService::class)->availableDays($master, $monthStart, $monthEnd, $minDate, $maxDate, $servicesForPreview)
            : [];

        $availabilityByDate = collect($availability)->keyBy('date');
        $todayDate = now(config('app.timezone'))->toDateString();
        $days = [];

        for ($day = $monthStart->copy(); $day->lte($monthEnd); $day->addDay()) {
            $date = $day->toDateString();
            $dayAvailability = $availabilityByDate->get($date, [
                'available' => false,
                'slots_count' => 0,
            ]);

            $days[] = [
                'date' => $date,
                'weekday' => $day->isoFormat('dd'),
                'day' => $day->day,
                'month' => $day->translatedFormat('M'),
                'available' => (bool) $dayAvailability['available'],
                'slots_count' => (int) $dayAvailability['slots_count'],
                'is_selected' => $date === $this->selectedDate,
                'is_today' => $date === $todayDate,
            ];
        }

        return $days;
    }

    public function slotsForSelectedDate(): array
    {
        if (! $this->selectedDate) {
            return [];
        }

        $settings = BookingSetting::current();
        $selectedDate = Carbon::parse($this->selectedDate, config('app.timezone'));

        if (! $settings->isWorkingDate($selectedDate)) {
            return [];
        }

        return collect($settings->slots())
            ->map(function (string $slot): array {
                $appointment = $this->appointmentForSlot($slot);
                $block = $this->blockForSlot($slot);

                return [
                    'time' => $slot,
                    'status' => $appointment ? 'appointment' : ($block ? 'blocked' : 'free'),
                    'appointment_id' => $appointment?->id,
                    'client' => $appointment?->client_name,
                    'master' => $appointment?->master?->name,
                    'block_id' => $block?->id,
                    'block_note' => $block?->note,
                ];
            })
            ->all();
    }

    public function selectedDateLabel(): ?string
    {
        if (! $this->selectedDate) {
            return null;
        }

        return Carbon::parse($this->selectedDate, config('app.timezone'))
            ->translatedFormat('l, j F Y р.');
    }

    public function selectedAppointment(): ?Appointment
    {
        if (! $this->selectedAppointmentId) {
            return null;
        }

        return Appointment::query()
            ->with('master')
            ->find($this->selectedAppointmentId);
    }

    public function fullDayBlock(): ?ScheduleBlock
    {
        if (! $this->selectedDate) {
            return null;
        }

        return ScheduleBlock::query()
            ->whereNull('master_id')
            ->whereDate('block_date', $this->selectedDate)
            ->where('is_full_day', true)
            ->first();
    }

    public function serviceLabel(?string $serviceKey): string
    {
        if (! $serviceKey) {
            return '—';
        }

        return MassageService::labelFor($serviceKey);
    }

    public function additionalServicesLabel(Appointment $appointment): string
    {
        $services = array_values(array_unique(array_filter([
            $appointment->additional_service,
            ...($appointment->additional_services ?? []),
        ])));

        if (! $services) {
            return 'Без додаткових послуг';
        }

        return collect($services)
            ->map(fn (string $service): string => $this->serviceLabel($service))
            ->join(', ');
    }

    public function appointmentDurationLabel(Appointment $appointment): string
    {
        $minutes = collect([
            $appointment->service,
            ...($appointment->additional_services ?? []),
        ])
            ->filter()
            ->map(fn (string $serviceKey): int => $this->serviceDurationInMinutes($serviceKey))
            ->sum();

        if ($minutes % 60 === 0) {
            return ($minutes / 60) . ' год';
        }

        return "{$minutes} хв";
    }

    private function monthStart(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', "{$this->monthKey}-01", config('app.timezone'))->startOfDay();
    }

    private function maxBookingDate(): Carbon
    {
        return now(config('app.timezone'))
            ->addMonthsNoOverflow(max($this->maxAdvanceMonths - 1, 0))
            ->endOfMonth();
    }

    private function firstAvailableDate(): ?string
    {
        return collect($this->calendarDays())
            ->firstWhere('available', true)['date'] ?? null;
    }

    private function previewMaster(): ?Master
    {
        return Master::active()->first();
    }

    private function appointmentForSlot(string $slot): ?Appointment
    {
        $slotTime = Carbon::parse(sprintf('%s %s', $this->selectedDate, $slot), config('app.timezone'));

        return Appointment::query()
            ->with('master')
            ->activeSlot()
            ->whereDate('appointment_date', $this->selectedDate)
            ->get()
            ->first(fn (Appointment $appointment): bool => $this->appointmentCoversSlot($appointment, $slotTime));
    }

    private function blockForSlot(string $slot): ?ScheduleBlock
    {
        $slotStart = Carbon::parse(sprintf('%s %s', $this->selectedDate, $slot), config('app.timezone'));
        $slotEnd = $slotStart->copy()->addMinutes($this->slotStepInMinutes());

        return ScheduleBlock::query()
            ->whereDate('block_date', $this->selectedDate)
            ->where(function ($query): void {
                $query->whereNull('master_id');
            })
            ->get()
            ->first(function (ScheduleBlock $block) use ($slotStart, $slotEnd): bool {
                if ($block->is_full_day) {
                    return true;
                }

                if (! $block->start_time || ! $block->end_time) {
                    return false;
                }

                $blockStart = Carbon::parse(sprintf('%s %s', $this->selectedDate, substr((string) $block->start_time, 0, 5)), config('app.timezone'));
                $blockEnd = Carbon::parse(sprintf('%s %s', $this->selectedDate, substr((string) $block->end_time, 0, 5)), config('app.timezone'));

                return $this->rangesOverlap($slotStart, $slotEnd, $blockStart, $blockEnd);
            });
    }

    private function appointmentCoversSlot(Appointment $appointment, CarbonInterface $slotTime): bool
    {
        $appointmentStart = Carbon::parse(
            sprintf('%s %s', $appointment->appointment_date->toDateString(), substr((string) $appointment->appointment_time, 0, 5)),
            config('app.timezone'),
        );
        $appointmentEnd = $appointmentStart->copy()->addMinutes($this->appointmentDurationInMinutes($appointment));

        return $slotTime->gte($appointmentStart) && $slotTime->lt($appointmentEnd);
    }

    private function appointmentDurationInMinutes(Appointment $appointment): int
    {
        return collect([
            $appointment->service,
            ...($appointment->additional_services ?? []),
        ])
            ->filter()
            ->map(fn (string $serviceKey): int => $this->serviceDurationInMinutes($serviceKey))
            ->sum();
    }

    private function serviceDurationInMinutes(string $serviceKey): int
    {
        return MassageService::durationFor($serviceKey);
    }

    private function slotStepInMinutes(): int
    {
        $settings = BookingSetting::current();
        $slots = collect($settings->slots())->values();

        if ($slots->count() < 2) {
            return max((int) $settings->slot_step_minutes, 1);
        }

        $first = Carbon::parse((string) $slots->get(0), config('app.timezone'));
        $second = Carbon::parse((string) $slots->get(1), config('app.timezone'));

        return max($first->diffInMinutes($second), 1);
    }

    private function rangesOverlap(
        CarbonInterface $start,
        CarbonInterface $end,
        CarbonInterface $otherStart,
        CarbonInterface $otherEnd,
    ): bool {
        return $start->lt($otherEnd) && $end->gt($otherStart);
    }
}
