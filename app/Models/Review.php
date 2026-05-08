<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'client_name',
        'master_id',
        'text',
        'rating',
        'status',
        'published_at',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'published_at' => 'datetime',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_DRAFT => 'Чернетка',
            self::STATUS_PUBLISHED => 'Опубліковано',
        ];
    }

    public function master(): BelongsTo
    {
        return $this->belongsTo(Master::class);
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query
            ->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->latest('published_at');
    }

    public function publish(): void
    {
        $this->forceFill([
            'status' => self::STATUS_PUBLISHED,
            'published_at' => $this->published_at ?: now(),
        ])->save();
    }

    public function moveToDraft(): void
    {
        $this->forceFill([
            'status' => self::STATUS_DRAFT,
            'published_at' => null,
        ])->save();
    }

    public static function purgeExpiredTrash(): void
    {
        self::onlyTrashed()
            ->where('deleted_at', '<=', now()->subDays(30))
            ->forceDelete();
    }
}
