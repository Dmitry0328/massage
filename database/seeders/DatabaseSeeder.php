<?php

namespace Database\Seeders;

use App\Models\BookingSetting;
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
