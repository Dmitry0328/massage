<?php

use Database\Seeders\PublicCatalogSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $masters = [
            'olesia' => [
                'name' => 'Олеся',
                'phone' => '+380 (67) 876-41-83',
                'bio' => 'Майстер масажу з вищою освітою у сфері фізичного виховання. Працює з релаксом, відновленням та доглядом за тілом.',
                'sort_order' => 1,
            ],
            'serhii' => [
                'name' => 'Сергій',
                'phone' => '+380 (96) 605-98-23',
                'bio' => 'Майстер з глибоким знанням анатомії, досвідом роботи з мʼязовою напругою, болем та відновленням тіла.',
                'sort_order' => 2,
            ],
        ];

        foreach ($masters as $slug => $master) {
            DB::table('masters')->updateOrInsert(
                ['slug' => $slug],
                [
                    ...$master,
                    'is_active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            );
        }

        DB::table('masters')
            ->whereNotIn('slug', array_keys($masters))
            ->update([
                'is_active' => false,
                'updated_at' => $now,
            ]);

        $masterIds = DB::table('masters')
            ->whereIn('slug', array_keys($masters))
            ->pluck('id', 'slug');

        $catalog = app(PublicCatalogSeeder::class)->catalog();
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
