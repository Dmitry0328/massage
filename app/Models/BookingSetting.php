<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

class BookingSetting extends Model
{
    protected $fillable = [
        'max_advance_months',
        'working_days',
        'work_start_time',
        'work_end_time',
        'slot_step_minutes',
    ];

    protected $casts = [
        'working_days' => 'array',
    ];

    public static function current(): self
    {
        return self::query()->firstOrCreate([], [
            'max_advance_months' => 2,
            'working_days' => [1, 2, 3, 4, 5, 6, 7],
            'work_start_time' => '10:00',
            'work_end_time' => '18:00',
            'slot_step_minutes' => 60,
        ]);
    }

    public function workingDays(): array
    {
        return array_values(array_map('intval', $this->working_days ?: [1, 2, 3, 4, 5, 6, 7]));
    }

    public function slots(): array
    {
        $start = now(config('app.timezone'))->setTimeFromTimeString(substr((string) $this->work_start_time, 0, 5));
        $end = now(config('app.timezone'))->setTimeFromTimeString(substr((string) $this->work_end_time, 0, 5));
        $step = max((int) $this->slot_step_minutes, 15);
        $slots = [];

        if ($start->gte($end)) {
            return config('booking.slots', []);
        }

        while ($start->lt($end)) {
            $slots[] = $start->format('H:i');
            $start->addMinutes($step);
        }

        return $slots;
    }

    public function isWorkingDate(CarbonInterface $date): bool
    {
        return in_array((int) $date->isoWeekday(), $this->workingDays(), true);
    }

    public function scheduleLabel(): string
    {
        $days = $this->workingDays();
        $dayLabels = [
            1 => 'Пн',
            2 => 'Вт',
            3 => 'Ср',
            4 => 'Чт',
            5 => 'Пт',
            6 => 'Сб',
            7 => 'Нд',
        ];

        $label = match ($days) {
            [1, 2, 3, 4, 5] => 'Пн-Пт',
            [1, 2, 3, 4, 5, 6] => 'Пн-Сб',
            [1, 2, 3, 4, 5, 6, 7] => 'Щодня',
            default => collect($days)->map(fn (int $day): string => $dayLabels[$day] ?? '')->filter()->join(', '),
        };

        return sprintf('%s: %s - %s', $label, substr((string) $this->work_start_time, 0, 5), substr((string) $this->work_end_time, 0, 5));
    }
}
