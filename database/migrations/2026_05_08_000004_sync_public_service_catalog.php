<?php

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

        DB::table('services')
            ->whereNotNull('master_id')
            ->whereNotIn('master_id', $masterIds->values()->all())
            ->update([
                'is_active' => false,
                'updated_at' => $now,
            ]);

        foreach ($this->catalog() as $slug => $services) {
            $masterId = $masterIds[$slug] ?? null;

            if (! $masterId) {
                continue;
            }

            DB::table('services')
                ->where('master_id', $masterId)
                ->whereNotIn('key', array_column($services, 'key'))
                ->update([
                    'is_active' => false,
                    'updated_at' => $now,
                ]);

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
        // Current public catalog migration is intentionally not reverted.
    }

    private function catalog(): array
    {
        $apparatus = [
            ['miostimuliaciia', 'Міостимуляція'],
            ['endosfera', 'ЕНДОСФЕРА'],
            ['kavitaciia', 'Кавітація'],
            ['rf-lifting', 'RF- ліфтинг'],
            ['vakuumnii-masaz', 'Вакуумний масаж'],
            ['presoterapiia', 'Пресотерапія'],
        ];

        return [
            'olesia' => [
                $this->fixed('olesia-zagalnii-masaz-tila-120', 'Загальний масаж тіла', 120, 800, 'Повний масаж тіла для глибокого розслаблення та відновлення.'),
                $this->fixed('olesia-klasicnii-masaz-bud-iaka-zona-45', 'Класичний масаж (будь яка зона)', 45, 500, 'Класичний масаж однієї обраної зони.'),
                $this->fixed('olesia-limfodrenaz-45', 'Лімфодренаж', 45, 600, 'Лімфодренажний масаж для легкості та зменшення набряклості.'),
                $this->fixed('olesia-medovii-masaz-45', 'Медовий масаж', 45, 700, 'Медовий масаж для тонусу шкіри та активного опрацювання тканин.'),
                $this->fixed('olesia-masaz-obliccia-45', 'Масаж обличчя', 45, 500, 'Масаж обличчя для розслаблення, тонусу та свіжого вигляду.'),
                ...$this->apparatus('master-1', $apparatus),
            ],
            'serhii' => [
                $this->fixed('serhii-miopresura-60', 'Міопресура', 60, 700, 'Точкова робота з мʼязовою напругою та глибокими зонами.'),
                $this->fixed('serhii-zagalnii-masaz-vsyogo-tila-120', 'Загальний масаж всього тіла', 120, 1400, 'Повний масаж всього тіла для відновлення та розслаблення.'),
                $this->fixed('serhii-klasicnii-masaz-bud-iaka-zona-60', 'Класичний масаж (будь яка зона)', 60, 700, 'Класичний масаж однієї обраної зони.'),
                $this->fixed('serhii-vognianii-masaz-60', 'Вогняний масаж', 60, 900, 'Інтенсивна процедура з тепловим ефектом.'),
                $this->fixed('serhii-banocnii-masaz-60', 'Баночний масаж', 60, 500, 'Баночний масаж для активного опрацювання тканин.'),
                ...$this->apparatus('master-2', $apparatus),
            ],
        ];
    }

    private function fixed(string $key, string $label, int $duration, int $price, string $description): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'category' => 'Масаж',
            'duration_minutes' => $duration,
            'price' => $price,
            'is_price_per_minute' => false,
            'description' => $description,
        ];
    }

    private function apparatus(string $prefix, array $items): array
    {
        return array_map(fn (array $item): array => [
            'key' => "{$prefix}-{$item[0]}",
            'label' => $item[1],
            'category' => 'Апаратні масажі',
            'duration_minutes' => 60,
            'price' => 10,
            'is_price_per_minute' => true,
            'description' => 'Апаратний масаж: ціна вказана за 1 хвилину. Тривалість клієнт обирає у формі запису.',
        ], $items);
    }
};
