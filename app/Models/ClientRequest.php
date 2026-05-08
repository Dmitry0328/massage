<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientRequest extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'master_id',
        'client_name',
        'phone',
        'message',
        'status',
    ];

    public function master(): BelongsTo
    {
        return $this->belongsTo(Master::class);
    }

    /**
     * @return array<string, string>
     */
    public static function statusOptions(): array
    {
        return [
            self::STATUS_NEW => 'Новий запит',
            self::STATUS_CONTACTED => 'Передзвонили',
            self::STATUS_CLOSED => 'Закрито',
        ];
    }
}
