<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MassageService extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'master_id',
        'key',
        'label',
        'category',
        'duration_minutes',
        'price',
        'is_price_per_minute',
        'discount_percent',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_minutes' => 'integer',
        'price' => 'integer',
        'is_price_per_minute' => 'boolean',
        'discount_percent' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $service): void {
            if (blank($service->key)) {
                $suffix = $service->master_id ? "-master-{$service->master_id}" : '';
                $service->key = (Str::slug($service->label) ?: 'service') . $suffix;
            }
        });
    }

    public function master()
    {
        return $this->belongsTo(Master::class);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('label');
    }

    public static function activeCollection(): Collection
    {
        return self::query()->active()->get();
    }

    public static function activeForMaster(int|string|null $masterId): Collection
    {
        $services = self::query()
            ->active()
            ->where('master_id', $masterId)
            ->get();

        if ($services->isNotEmpty()) {
            return $services;
        }

        return self::query()
            ->active()
            ->whereNull('master_id')
            ->get();
    }

    public static function activeKeys(int|string|null $masterId = null): array
    {
        $services = $masterId
            ? self::activeForMaster($masterId)
            : self::activeCollection();

        return $services
            ->pluck('key')
            ->all();
    }

    public static function options(int|string|null $masterId = null): array
    {
        $services = $masterId
            ? self::activeForMaster($masterId)
            : self::activeCollection();

        return $services
            ->mapWithKeys(fn (self $service): array => [$service->key => $service->label])
            ->all();
    }

    public static function optionsWithMaster(): array
    {
        return self::query()
            ->with('master')
            ->active()
            ->get()
            ->mapWithKeys(fn (self $service): array => [
                $service->key => trim(($service->master?->name ? "{$service->master->name} - " : '') . $service->label),
            ])
            ->all();
    }

    public static function labelFor(?string $key): string
    {
        if (! $key) {
            return '—';
        }

        return (string) (self::query()->where('key', $key)->value('label') ?? config("booking.services.{$key}.label", $key));
    }

    public static function durationFor(string $key): int
    {
        $duration = self::query()->where('key', $key)->value('duration_minutes');

        if ($duration !== null) {
            return max((int) $duration, 0);
        }

        $fallback = (string) data_get(config('booking.services'), "{$key}.duration", '');

        return max((int) (preg_replace('/[^\d]/', '', $fallback) ?: 0), 0);
    }

    public function toBookingArray(): array
    {
        $apparatusBase = $this->apparatusBaseLabel();
        $isApparatus = $apparatusBase !== null;
        $usesDurationPicker = $this->is_price_per_minute;
        $minutePrice = $usesDurationPicker
            ? $this->price
            : ($isApparatus ? (int) round($this->price / max($this->duration_minutes, 1)) : null);
        $displayLabel = $usesDurationPicker ? $this->label : ($apparatusBase ?: $this->label);

        if ($usesDurationPicker && $isApparatus) {
            $displayLabel = $apparatusBase;
        }

        $durationPickerLabel = $displayLabel;
        $durationPickerGroup = $this->category ?: 'Послуги за хвилину';

        if ($usesDurationPicker && ! str_ends_with($durationPickerGroup, ':')) {
            $durationPickerGroup .= ':';
        }

        $isGroupedMinuteService = $usesDurationPicker;

        return [
            'key' => $this->key,
            'master_id' => (string) $this->master_id,
            'master_name' => $this->master?->name,
            'label' => $this->label,
            'display_label' => $displayLabel,
            'category' => $this->category,
            'is_apparatus' => $isApparatus,
            'is_price_per_minute' => $this->is_price_per_minute,
            'uses_duration_picker' => $usesDurationPicker,
            'duration_picker_group' => $durationPickerGroup,
            'duration_picker_label' => $durationPickerLabel,
            'apparatus_base' => $durationPickerLabel,
            'duration_minutes' => $this->duration_minutes,
            'minute_price' => $minutePrice,
            'duration' => $isGroupedMinuteService ? 'Оберіть час' : $this->duration_minutes . ' хв',
            'price' => $this->price,
            'old_price' => null,
            'badge' => $this->discount_percent > 0 ? "-{$this->discount_percent}%" : '',
            'description' => $this->description ?? '',
        ];
    }

    private function apparatusBaseLabel(): ?string
    {
        if ($this->category === 'Апаратні масажі') {
            return $this->normalizeApparatusLabel($this->label);
        }

        foreach ([
            'Міостимуляція' => 'Міостимуляція',
            'Кавітація' => 'Кавітація',
            'RF-ліфтинг' => 'RF- ліфтинг',
            'RF- ліфтинг' => 'RF- ліфтинг',
            'Вакуумний масаж' => 'Вакуумний масаж',
            'Пресотерапія' => 'Пресотерапія',
        ] as $prefix => $displayLabel) {
            if (str_starts_with($this->label, $prefix)) {
                return $displayLabel;
            }
        }

        return null;
    }

    private function normalizeApparatusLabel(string $label): string
    {
        return str_starts_with($label, 'RF-') ? 'RF- ліфтинг' : $label;
    }
}
