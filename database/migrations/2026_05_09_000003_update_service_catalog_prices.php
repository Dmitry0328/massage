<?php

use Database\Seeders\PublicCatalogSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $catalog = app(PublicCatalogSeeder::class)->catalog();

        $masterIds = DB::table('masters')
            ->whereIn('slug', array_keys($catalog))
            ->pluck('id', 'slug');

        $currentServiceKeys = collect($catalog)
            ->flatten(1)
            ->pluck('key')
            ->all();

        DB::table('services')
            ->whereNotIn('key', $currentServiceKeys)
            ->update([
                'is_active' => false,
                'updated_at' => $now,
            ]);

        foreach ($catalog as $slug => $services) {
            $masterId = $masterIds[$slug] ?? null;

            if (! $masterId) {
                continue;
            }

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
                        'sort_order' => $index + 1,
                        'updated_at' => $now,
                        'created_at' => $now,
                    ],
                );
            }
        }
    }

    public function down(): void
    {
        //
    }
};
