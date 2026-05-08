<?php

namespace Database\Seeders;

use App\Models\BookingSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'show_quick_book_block' => false,
        ]);

        $this->call(PublicCatalogSeeder::class);
    }
}
