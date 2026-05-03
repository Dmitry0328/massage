<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\BookingSetting;
use App\Models\Master;
use App\Models\MassageService;
use App\Models\ScheduleBlock;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class BookingAvailabilityService
{
    public function availableSlots(Master $master, string $date, array $serviceKeys = [], array $durationOverrides = []): array
    {
        $normalizedDate = Carbon::parse($date, config('app.timezone'))->toDateString();

        return collect(BookingSetting::current()->slots())
            ->filter(fn (string $slot): bool => $this->isAvailable($master, $normalizedDate, $slot, $serviceKeys, null, $durationOverrides))
            ->values()
            ->all();
    }

    public function availableDays(
        Master $master,
        CarbonInterface $monthStart,
        CarbonInterface $monthEnd,
        CarbonInterface $minDate,
        CarbonInterface $maxDate,
        array $serviceKeys = [],
        array $durationOverrides = [],
    ): array {
        $days = [];
        $current = $monthStart->copy()->startOfDay();

        while ($current->lte($monthEnd)) {
            $withinRange = $current->betweenIncluded($minDate, $maxDate);
            $slots = $withinRange ? $this->availableSlots($master, $current->toDateString(), $serviceKeys, $durationOverrides) : [];

            $days[] = [
                'date' => $current->toDateString(),
                'available' => $withinRange && count($slots) > 0,
                'slots_count' => count($slots),
            ];

            $current->addDay();
        }

        return $days;
    }

    public function isAvailable(
        Master $master,
        string $date,
        string $time,
        array $serviceKeys = [],
        ?int $ignoreAppointmentId = null,
        array $durationOverrides = [],
    ): bool {
        $dateTime = Carbon::parse(sprintf('%s %s', $date, $time), config('app.timezone'));
        $endDateTime = $dateTime->copy()->addMinutes($this->resolveDurationInMinutes($serviceKeys, $durationOverrides));

        $settings = BookingSetting::current();

        if (! in_array($dateTime->format('H:i'), $settings->slots(), true)) {
            return false;
        }

        if (! in_array((int) $dateTime->isoWeekday(), $settings->workingDays(), true)) {
            return false;
        }

        if ($dateTime->isPast()) {
            return false;
        }

        if ($endDateTime->gt($this->dayBoundary($dateTime))) {
            return false;
        }

        if ($this->isBlockedBySchedule($master, $dateTime, $endDateTime)) {
            return false;
        }

        $appointments = Appointment::query()
            ->activeSlot()
            ->whereDate('appointment_date', $dateTime->toDateString())
            ->when($ignoreAppointmentId, fn ($query) => $query->whereKeyNot($ignoreAppointmentId))
            ->get();

        foreach ($appointments as $appointment) {
            $appointmentStart = Carbon::parse(
                sprintf('%s %s', $appointment->appointment_date->toDateString(), substr((string) $appointment->appointment_time, 0, 5)),
                config('app.timezone'),
            );
            $appointmentEnd = $appointmentStart->copy()->addMinutes($this->appointmentDurationInMinutes($appointment));

            if ($this->rangesOverlap($dateTime, $endDateTime, $appointmentStart, $appointmentEnd)) {
                return false;
            }
        }

        return true;
    }

    public function availableAdditionalServices(
        Master $master,
        string $date,
        string $time,
        string $primaryService,
        array $selectedAdditionalServices = [],
        ?int $ignoreAppointmentId = null,
        array $durationOverrides = [],
    ): array {
        $currentServices = array_values(array_unique(array_filter([
            $primaryService,
            ...$selectedAdditionalServices,
        ])));

        return collect(MassageService::activeKeys($master->id))
            ->reject(fn (string $serviceKey): bool => in_array($serviceKey, $currentServices, true))
            ->filter(function (string $candidateService) use ($master, $date, $time, $currentServices, $ignoreAppointmentId, $durationOverrides): bool {
                return $this->isAvailable(
                    $master,
                    $date,
                    $time,
                    [...$currentServices, $candidateService],
                    $ignoreAppointmentId,
                    $durationOverrides,
                );
            })
            ->values()
            ->all();
    }

    private function isBlockedBySchedule(Master $master, CarbonInterface $start, CarbonInterface $end): bool
    {
        return ScheduleBlock::query()
            ->whereDate('block_date', $start->toDateString())
            ->where(function ($query) use ($master): void {
                $query
                    ->whereNull('master_id')
                    ->orWhere('master_id', $master->id);
            })
            ->get()
            ->contains(function (ScheduleBlock $block) use ($start, $end): bool {
                if ($block->is_full_day) {
                    return true;
                }

                if (! $block->start_time || ! $block->end_time) {
                    return false;
                }

                $blockStart = Carbon::parse(
                    sprintf('%s %s', $block->block_date->toDateString(), substr((string) $block->start_time, 0, 5)),
                    config('app.timezone'),
                );
                $blockEnd = Carbon::parse(
                    sprintf('%s %s', $block->block_date->toDateString(), substr((string) $block->end_time, 0, 5)),
                    config('app.timezone'),
                );

                return $this->rangesOverlap($start, $end, $blockStart, $blockEnd);
            });
    }

    private function appointmentDurationInMinutes(Appointment $appointment): int
    {
        return $this->resolveDurationInMinutes(array_values(array_filter([
            $appointment->service,
            ...($appointment->additional_services ?? []),
        ])), $appointment->service_durations ?? []);
    }

    private function resolveDurationInMinutes(array $serviceKeys, array $durationOverrides = []): int
    {
        return max(
            collect($serviceKeys)
                ->filter()
                ->map(fn (string $serviceKey): int => $this->serviceDurationInMinutes($serviceKey, $durationOverrides))
                ->sum(),
            0,
        );
    }

    private function serviceDurationInMinutes(string $serviceKey, array $durationOverrides = []): int
    {
        if (isset($durationOverrides[$serviceKey])) {
            return max((int) $durationOverrides[$serviceKey], 1);
        }

        return MassageService::durationFor($serviceKey);
    }

    private function dayBoundary(CarbonInterface $dateTime): CarbonInterface
    {
        $settings = BookingSetting::current();
        $slots = collect($settings->slots())->values();
        $lastSlot = (string) $slots->last();
        $stepInMinutes = max((int) $settings->slot_step_minutes, 1);

        if ($slots->count() > 1) {
            $first = Carbon::parse((string) $slots->get(0), config('app.timezone'));
            $second = Carbon::parse((string) $slots->get(1), config('app.timezone'));
            $stepInMinutes = max($first->diffInMinutes($second), 1);
        }

        return Carbon::parse(
            sprintf('%s %s', $dateTime->toDateString(), $lastSlot),
            config('app.timezone'),
        )->addMinutes($stepInMinutes);
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
