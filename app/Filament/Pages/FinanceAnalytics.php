<?php

namespace App\Filament\Pages;

use App\Models\Appointment;
use App\Models\ClientRequest;
use App\Models\MassageService;
use App\Models\ScheduleBlock;
use BackedEnum;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class FinanceAnalytics extends Page
{
    protected string $view = 'filament.pages.finance-analytics';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'Аналітика фінансів';

    protected static ?string $title = 'Аналітика фінансів';

    protected static ?int $navigationSort = 25;

    public string $pin = '';

    public bool $isUnlocked = false;

    public string $dateFrom = '';

    public string $dateTo = '';

    public function mount(): void
    {
        $this->isUnlocked = false;
        $this->dateFrom = now(config('app.timezone'))->startOfMonth()->toDateString();
        $this->dateTo = now(config('app.timezone'))->endOfMonth()->toDateString();
    }

    public function unlock(): void
    {
        if ($this->pin !== '1122') {
            Notification::make()
                ->title('Невірний PIN код')
                ->danger()
                ->send();

            return;
        }

        $this->isUnlocked = true;
        $this->pin = '';

        Notification::make()
            ->title('Аналітику відкрито')
            ->success()
            ->send();
    }

    public function lock(): void
    {
        $this->isUnlocked = false;
        $this->pin = '';
    }

    public function setCurrentMonth(): void
    {
        $this->dateFrom = now(config('app.timezone'))->startOfMonth()->toDateString();
        $this->dateTo = now(config('app.timezone'))->endOfMonth()->toDateString();
    }

    public function setPreviousMonth(): void
    {
        $month = now(config('app.timezone'))->subMonthNoOverflow();
        $this->dateFrom = $month->copy()->startOfMonth()->toDateString();
        $this->dateTo = $month->copy()->endOfMonth()->toDateString();
    }

    public function setCurrentYear(): void
    {
        $this->dateFrom = now(config('app.timezone'))->startOfYear()->toDateString();
        $this->dateTo = now(config('app.timezone'))->endOfYear()->toDateString();
    }

    public function summary(): array
    {
        $appointments = $this->appointments();
        $services = MassageService::query()->get()->keyBy('key');
        $completed = $appointments->where('status', Appointment::STATUS_COMPLETED);
        $cancelled = $appointments->where('status', Appointment::STATUS_CANCELLED);
        $planned = $appointments->whereIn('status', [
            Appointment::STATUS_PENDING,
            Appointment::STATUS_CONFIRMED,
        ]);

        $completedRevenue = $this->appointmentsRevenue($completed, $services);
        $cancelledRevenue = $this->appointmentsRevenue($cancelled, $services);
        $plannedRevenue = $this->appointmentsRevenue($planned, $services);
        $workedMinutes = $completed->sum(fn (Appointment $appointment): int => $this->appointmentDurationMinutes($appointment, $services));
        $fullDayBlocks = ScheduleBlock::query()
            ->whereBetween('block_date', [$this->safeDateFrom(), $this->safeDateTo()])
            ->where('is_full_day', true)
            ->count();
        $callbackRequests = ClientRequest::query()
            ->whereBetween('created_at', [
                $this->safeDateFrom()->copy()->startOfDay(),
                $this->safeDateTo()->copy()->endOfDay(),
            ])
            ->count();

        return [
            'appointments_total' => $appointments->count(),
            'unique_clients' => $appointments->pluck('phone')->filter()->unique()->count(),
            'pending' => $appointments->where('status', Appointment::STATUS_PENDING)->count(),
            'confirmed' => $appointments->where('status', Appointment::STATUS_CONFIRMED)->count(),
            'completed' => $completed->count(),
            'cancelled' => $cancelled->count(),
            'full_day_blocks' => $fullDayBlocks,
            'worked_hours' => round($workedMinutes / 60, 1),
            'worked_minutes' => $workedMinutes,
            'completed_revenue' => $completedRevenue,
            'cancelled_revenue' => $cancelledRevenue,
            'planned_revenue' => $plannedRevenue,
            'all_potential_revenue' => $completedRevenue + $cancelledRevenue + $plannedRevenue,
            'callback_requests' => $callbackRequests,
            'chart' => $this->chartData($appointments, $services),
        ];
    }

    public function periodLabel(): string
    {
        return $this->safeDateFrom()->format('d.m.Y') . ' - ' . $this->safeDateTo()->format('d.m.Y');
    }

    public function money(int|float $amount): string
    {
        return number_format((float) $amount, 0, '.', ' ') . ' грн';
    }

    private function appointments(): EloquentCollection
    {
        return Appointment::query()
            ->whereBetween('appointment_date', [$this->safeDateFrom(), $this->safeDateTo()])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
    }

    private function appointmentsRevenue(Collection|EloquentCollection $appointments, Collection $services): int
    {
        return (int) $appointments->sum(fn (Appointment $appointment): int => $this->appointmentRevenue($appointment, $services));
    }

    private function appointmentRevenue(Appointment $appointment, Collection $services): int
    {
        return collect($this->appointmentServiceKeys($appointment))
            ->sum(function (string $serviceKey) use ($appointment, $services): int {
                /** @var MassageService|null $service */
                $service = $services->get($serviceKey);

                if (! $service) {
                    return 0;
                }

                if ($service->is_price_per_minute) {
                    $minutes = (int) data_get($appointment->service_durations ?? [], $serviceKey, $service->duration_minutes);

                    return max($minutes, 0) * (int) $service->price;
                }

                return (int) $service->price;
            });
    }

    private function appointmentDurationMinutes(Appointment $appointment, Collection $services): int
    {
        return collect($this->appointmentServiceKeys($appointment))
            ->sum(function (string $serviceKey) use ($appointment, $services): int {
                /** @var MassageService|null $service */
                $service = $services->get($serviceKey);
                $defaultDuration = $service?->duration_minutes ?? MassageService::durationFor($serviceKey);

                return max((int) data_get($appointment->service_durations ?? [], $serviceKey, $defaultDuration), 0);
            });
    }

    private function appointmentServiceKeys(Appointment $appointment): array
    {
        return collect([$appointment->service])
            ->merge($appointment->additional_services ?? [])
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function chartData(EloquentCollection $appointments, Collection $services): array
    {
        $days = collect(CarbonPeriod::create($this->safeDateFrom(), $this->safeDateTo()))
            ->map(fn (Carbon $date): array => [
                'date' => $date->toDateString(),
                'label' => $date->format('d.m'),
                'revenue' => 0,
                'lost' => 0,
                'count' => 0,
            ])
            ->keyBy('date');

        foreach ($appointments as $appointment) {
            $date = $appointment->appointment_date?->toDateString();

            if (! $date || ! $days->has($date)) {
                continue;
            }

            $revenue = $this->appointmentRevenue($appointment, $services);
            $day = $days->get($date);

            if ($appointment->status === Appointment::STATUS_COMPLETED) {
                $day['revenue'] += $revenue;
                $day['count']++;
            }

            if ($appointment->status === Appointment::STATUS_CANCELLED) {
                $day['lost'] += $revenue;
            }

            $days->put($date, $day);
        }

        $max = max(1, $days->max(fn (array $day): int => max($day['revenue'], $day['lost'])));

        return $days
            ->map(function (array $day) use ($max): array {
                $day['revenue_height'] = max($day['revenue'] > 0 ? 12 : 0, (int) round(($day['revenue'] / $max) * 120));
                $day['lost_height'] = max($day['lost'] > 0 ? 8 : 0, (int) round(($day['lost'] / $max) * 80));

                return $day;
            })
            ->values()
            ->all();
    }

    private function safeDateFrom(): Carbon
    {
        return Carbon::parse($this->dateFrom ?: now(config('app.timezone'))->startOfMonth()->toDateString())->startOfDay();
    }

    private function safeDateTo(): Carbon
    {
        $from = $this->safeDateFrom();
        $to = Carbon::parse($this->dateTo ?: now(config('app.timezone'))->endOfMonth()->toDateString())->endOfDay();

        return $to->lessThan($from) ? $from->copy()->endOfDay() : $to;
    }
}
