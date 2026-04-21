<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSetting extends Model
{
    protected $fillable = [
        'max_advance_months',
    ];

    public static function current(): self
    {
        return self::query()->firstOrCreate([], [
            'max_advance_months' => 2,
        ]);
    }
}
