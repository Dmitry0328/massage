<?php

use Database\Seeders\PublicCatalogSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $masterId = DB::table('masters')->where('slug', 'serhii')->value('id');

        if (! $masterId) {
            return;
        }

        $services = collect(app(PublicCatalogSeeder::class)->catalog()['serhii'] ?? [])
            ->filter(fn (array $service): bool => (bool) ($service['is_price_per_minute'] ?? false))
            ->values();

        foreach ($services as $index => $service) {
            DB::table('services')->updateOrInsert(
                ['key' => $service['key']],
                [
                    'master_id' => $masterId,
                    'label' => $service['label'],
                    'category' => $service['category'],
                    'duration_minutes' => $service['duration_minutes'],
                    'price' => $service['price'],
                    'is_price_per_minute' => $service['is_price_per_minute'],
                    'discount_percent' => 0,
                    'description' => $service['description'],
                    'is_active' => true,
                    'sort_order' => 11 + $index,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            );
        }
    }

    public function down(): void
    {
        $keys = collect(app(PublicCatalogSeeder::class)->catalog()['serhii'] ?? [])
            ->filter(fn (array $service): bool => (bool) ($service['is_price_per_minute'] ?? false))
            ->pluck('key')
            ->all();

        DB::table('services')
            ->whereIn('key', $keys)
            ->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
    }
};
