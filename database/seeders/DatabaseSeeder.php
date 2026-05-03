<?php

namespace Database\Seeders;

use App\Models\BookingSetting;
use App\Models\MassageService;
use App\Models\Master;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@massage.local',
        ], [
            'name' => 'Massage Admin',
            'password' => Hash::make('Massage2026!'),
        ]);

        BookingSetting::query()->firstOrCreate([], [
            'max_advance_months' => 2,
        ]);

        collect(config('booking.services', []))->each(function (array $service, string $key): void {
            MassageService::query()->firstOrCreate([
                'key' => $key,
            ], [
                'label' => $service['label'] ?? $key,
                'duration_minutes' => (int) (preg_replace('/[^\d]/', '', (string) ($service['duration'] ?? '60')) ?: 60),
                'price' => (int) ($service['price'] ?? 0),
                'discount_percent' => (int) (preg_replace('/[^\d]/', '', (string) ($service['badge'] ?? '')) ?: 0),
                'description' => $service['description'] ?? null,
                'is_active' => true,
            ]);
        });

        collect([
            ['name' => 'Анна', 'phone' => '+380 67 000 00 01', 'bio' => 'Класичний та розслабляючий масаж.', 'sort_order' => 1],
            ['name' => 'Марія', 'phone' => '+380 67 000 00 02', 'bio' => 'Оздоровчі та відновлювальні процедури.', 'sort_order' => 2],
        ])->each(function (array $master): void {
            Master::query()->updateOrCreate(
                ['slug' => Str::slug($master['name'])],
                $master + ['is_active' => true],
            );
        });
    }
}
