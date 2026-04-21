<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Master;
use App\Models\ScheduleBlock;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class BookingAvailabilityService
{
    public function availableSlots(Master $master, string $date, array $serviceKeys = []): array
    {
        $normalizedDate = Carbon::parse($date, config('app.timezone'))->toDateString();

        return collect(config('booking.slots'))
            ->filter(fn (string $slot): bool => $this->isAvailable($master, $normalizedDate, $slot, $serviceKeys))
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
    ): array {
        $days = [];
        $current = $monthStart->copy()->startOfDay();

        while ($current->lte($monthEnd)) {
            $withinRange = $current->betweenIncluded($minDate, $maxDate);
            $slots = $withinRange ? $this->availableSlots($master, $current->toDateString(), $serviceKeys) : [];

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
    ): bool {
        $dateTime = Carbon::parse(sprintf('%s %s', $date, $time), config('app.timezone'));
        $endDateTime = $dateTime->copy()->addMinutes($this->resolveDurationInMinutes($serviceKeys));

        if (! in_array($dateTime->format('H:i'), config('booking.slots'), true)) {
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
            ->where('master_id', $master->id)
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
    ): array {
        $currentServices = array_values(array_unique(array_filter([
            $primaryService,
            ...$selectedAdditionalServices,
        ])));

        return collect(array_keys(config('booking.services')))
            ->reject(fn (string $serviceKey): bool => in_array($serviceKey, $currentServices, true))
            ->filter(function (string $candidateService) use ($master, $date, $time, $currentServices, $ignoreAppointmentId): bool {
                return $this->isAvailable(
                    $master,
                    $date,
                    $time,
                    [...$currentServices, $candidateService],
                    $ignoreAppointmentId,
                );
            })
            ->values()
            ->all();
    }

    private function isBlockedBySchedule(Master $master, CarbonInterface $start, CarbonInterface $end): bool
    {
        return ScheduleBlock::query()
            ->where('master_id', $master->id)
            ->whereDate('block_date', $start->toDateString())
            ->get()
            ->contains(function (ScheduleBlock $block) use ($start, $end): bool {
                if ($block->is_full_day) {
                    return true;
                }

                if (! $block->start_time || ! $block->end_time) {
                    return false;
                }

                $blockStart = Carbon::parse(
                    sprintf('%s %s', $block->block_date->toDateString(), substr($block->start_time, 0, 5)),
                    config('app.timezone'),
                );
                $blockEnd = Carbon::parse(
                    sprintf('%s %s', $block->block_date->toDateString(), substr($block->end_time, 0, 5)),
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
        ])));
    }

    private function resolveDurationInMinutes(array $serviceKeys): int
    {
        return max(
            collect($serviceKeys)
                ->filter()
                ->map(fn (string $serviceKey): int => $this->serviceDurationInMinutes($serviceKey))
                ->sum(),
            0,
        );
    }

    private function serviceDurationInMinutes(string $serviceKey): int
    {
        $duration = (string) data_get(config('booking.services'), sprintf('%s.duration', $serviceKey), '');
        $normalizedDuration = preg_replace('/[^\d]/', '', $duration) ?: '0';

        return max((int) $normalizedDuration, 0);
    }

    private function dayBoundary(CarbonInterface $dateTime): CarbonInterface
    {
        $slots = collect(config('booking.slots'))->values();
        $lastSlot = (string) $slots->last();
        $stepInMinutes = 60;

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
