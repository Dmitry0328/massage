<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'master_id',
        'client_name',
        'phone',
        'service',
        'additional_service',
        'additional_services',
        'service_durations',
        'appointment_date',
        'appointment_time',
        'social_contact',
        'message',
        'status',
        'source',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'additional_services' => 'array',
        'service_durations' => 'array',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Нова',
            self::STATUS_CONFIRMED => 'Підтверджено',
            self::STATUS_COMPLETED => 'Завершено',
            self::STATUS_CANCELLED => 'Скасовано',
        ];
    }

    public static function activeStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
        ];
    }

    public function scopeActiveSlot(Builder $query): Builder
    {
        return $query->whereIn('status', self::activeStatuses());
    }

    public function master()
    {
        return $this->belongsTo(Master::class);
    }
}
