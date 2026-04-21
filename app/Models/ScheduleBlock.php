<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleBlock extends Model
{
    protected $fillable = [
        'master_id',
        'block_date',
        'is_full_day',
        'start_time',
        'end_time',
        'note',
    ];

    protected $casts = [
        'block_date' => 'date',
        'is_full_day' => 'boolean',
    ];

    public function master()
    {
        return $this->belongsTo(Master::class);
    }
}
