<?php

namespace Database\Seeders;

use App\Models\MassageService;
use App\Models\Master;
use Illuminate\Database\Seeder;

class PublicCatalogSeeder extends Seeder
{
    public function run(): void
    {
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

        foreach ($masters as $slug => $data) {
            Master::query()->updateOrCreate(
                ['slug' => $slug],
                $data + ['is_active' => true],
            );
        }

        $masterIds = Master::query()
            ->whereIn('slug', array_keys($masters))
            ->pluck('id', 'slug');

        $currentKeys = collect($this->catalog())
            ->flatten(1)
            ->pluck('key')
            ->all();

        MassageService::query()
            ->whereNotIn('key', $currentKeys)
            ->update(['is_active' => false]);

        foreach ($this->catalog() as $slug => $services) {
            $masterId = $masterIds[$slug] ?? null;

            if (! $masterId) {
                continue;
            }

            foreach ($services as $index => $service) {
                MassageService::query()->updateOrCreate(
                    ['key' => $service['key']],
                    $service + [
                        'master_id' => $masterId,
                        'discount_percent' => 0,
                        'is_active' => true,
                        'sort_order' => $index + 1,
                    ],
                );
            }
        }
    }

    /**
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function catalog(): array
    {
        $apparatus = [
            ['miostimuliaciia', 'Міостимуляція'],
            ['kavitaciia', 'Кавітація'],
            ['rf-lifting', 'RF- ліфтинг'],
            ['vakuumnii-masaz', 'Вакуумний масаж'],
            ['presoterapiia', 'Пресотерапія'],
        ];

        return [
            'olesia' => [
                $this->fixed('olesia-zagalnii-masaz-tila-120', 'Загальний масаж тіла', 120, 800, 'Покращує кровообіг, знімає мʼязову напругу, розслабляє та допомагає відновитися після навантажень.'),
                $this->fixed('olesia-klasicnii-masaz-bud-iaka-odna-zona-45', 'Класичний масаж (будь яка одна зона)', 45, 500, 'Покращує кровообіг, знімає мʼязову напругу, розслабляє та допомагає відновитися після навантажень.'),
                $this->fixed('olesia-limfodrenaz-45', 'Лімфодренаж', 45, 600, 'Виводить зайву рідину, зменшує набряки, покращує роботу лімфатичної системи та сприяє полегшенню відчуття важкості.'),
                $this->fixed('olesia-medovii-masaz-45', 'Медовий масаж', 45, 700, 'Виводить токсини, стимулює обмін речовин, підтягує шкіру й добре працює для детоксикації організму.'),
                $this->fixed('olesia-masaz-obliccia-45', 'Масаж обличчя', 45, 500, 'Покращує тонус шкіри, стимулює кровообіг, має ліфтинговий ефект, зменшує набряки та сприяє омолодженню.'),
                ...$this->apparatus('master-1', $apparatus),
            ],
            'serhii' => [
                $this->fixed('serhii-miopresura-60', 'Міопресура', 60, 700, 'Поєднання тиску та апаратної стимуляції для розслаблення мʼязів, зняття болю та покращення рухливості.'),
                $this->fixed('serhii-zagalnii-masaz-vsyogo-tila-120', 'Загальний масаж всього тіла', 120, 1400, 'Покращує кровообіг, знімає мʼязову напругу, розслабляє та допомагає відновитися після навантажень.'),
                $this->fixed('serhii-klasicnii-masaz-bud-iaka-zona-60', 'Класичний масаж (будь яка зона)', 60, 700, 'Покращує кровообіг, знімає мʼязову напругу, розслабляє та допомагає відновитися після навантажень.'),
                $this->fixed('serhii-vognianii-masaz-60', 'Вогняний масаж', 60, 900, 'Інтенсивна процедура з тепловим ефектом для глибокого прогрівання і розслаблення.'),
                $this->fixed('serhii-banocnii-masaz-60', 'Баночний масаж', 60, 500, 'Глибоко опрацьовує тканини, покращує кровотік, розщеплює жирові відкладення, ефективний проти целюліту.'),
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
            'description' => match ($item[1]) {
                'Міостимуляція' => 'Апаратна стимуляція мʼязів для тонусу, розслаблення та підтримки відновлення.',
                'Кавітація' => 'Ультразвук руйнує жирові клітини, допомагаючи зменшити обʼєми та покращити контури тіла.',
                'RF- ліфтинг' => 'Радіохвилі стимулюють вироблення колагену — шкіра стає більш підтягнутою та еластичною.',
                'Вакуумний масаж' => 'Глибоко опрацьовує тканини, покращує кровообіг і допомагає зменшити прояви целюліту.',
                'Пресотерапія' => 'Апаратна компресія стимулює лімфодренаж, допомагає зменшити набряки та втому ніг.',
                default => 'Апаратний масаж: ціна вказана за 1 хвилину. Тривалість клієнт обирає у формі запису.',
            },
        ], $items);
    }
}
