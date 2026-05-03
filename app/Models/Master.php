<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Master extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'phone',
        'bio',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $master): void {
            if (blank($master->slug)) {
                $master->slug = Str::slug($master->name);
            }
        });
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query
            ->where('is_active', true)
            ->orderBy('name');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function services()
    {
        return $this->hasMany(MassageService::class);
    }

}
