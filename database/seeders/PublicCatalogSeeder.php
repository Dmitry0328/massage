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
                'sort_order' => 2,
            ],
            'serhii' => [
                'name' => 'Сергій',
                'phone' => '+380 (96) 605-98-23',
                'bio' => 'Майстер з глибоким знанням анатомії, досвідом роботи з мʼязовою напругою, болем та відновленням тіла.',
                'sort_order' => 1,
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
            ['endosfera', 'Ендосфера'],
            ['kavitaciia', 'Кавітація'],
            ['rf-lifting', 'RF-ліфтинг'],
            ['vakuumnii-masaz', 'Вакуумний масаж'],
            ['presoterapiia', 'Пресотерапія'],
        ];

        return [
            'olesia' => [
                $this->fixed('olesia-zagalnii-masaz-tila-120', 'Загальний масаж тіла', 120, 800, 'Ідеальний варіант, коли тіло втомлене, а голова перевантажена — масаж допомагає повністю перезавантажитись і відчути легкість у всьому тілі.'),
                $this->fixed('olesia-klasicnii-masaz-bud-iaka-zona-45', 'Класичний масаж (будь-яка зона)', 45, 500, 'Якщо турбує спина, шия чи інша зона — цей масаж швидко допоможе зняти дискомфорт і м’язові затиски.'),
                $this->fixed('olesia-limfodrenaz-45', 'Лімфодренаж', 45, 600, 'Масаж запускає природне очищення організму, дарує легкість та допомагає тілу виглядати більш підтягнутим.'),
                $this->fixed('olesia-medovii-masaz-45', 'Медовий масаж', 45, 700, 'Мед активно прогріває тіло, покращує кровообіг і залишає приємне відчуття оновлення після сеансу.'),
                $this->fixed('olesia-masaz-obliccia-dekolte-60', 'Масаж обличчя + декольте', 60, 500, 'Допомагає швидко освіжити обличчя, зняти сліди втоми та повернути шкірі здоровий тонус.'),
                ...$this->apparatus('master-1', $apparatus),
            ],
            'serhii' => [
                $this->fixed('serhii-zagalnii-masaz-tila-120', 'Загальний масаж тіла', 120, 1600, 'Ідеальний варіант, коли тіло втомлене, а голова перевантажена — масаж допомагає повністю перезавантажитись і відчути легкість у всьому тілі.'),
                $this->fixed('serhii-miopresura-shkz-90', 'Міопресура ШКЗ (шийно-комірцева зона)', 90, 1000, 'Ідеальний масаж для людей із сидячою роботою, постійною напругою в шиї та головними болями.'),
                $this->fixed('serhii-masaz-shkz-45', 'Масаж ШКЗ (шийно-комірцева зона)', 45, 500, 'Швидке розслаблення для шиї та плечей після стресу, роботи чи фізичного навантаження.'),
                $this->fixed('serhii-spina-ruki-shiya-90', 'Спина + руки + шия', 90, 1000, 'Комплексний масаж для тих, хто відчуває втому у спині, плечах та руках.'),
                $this->fixed('serhii-miopresura-nig-90', 'Міопресура ніг', 90, 800, 'Глибока робота з м’язами ніг для усунення болю, затисків та перенавантаження.'),
                $this->fixed('serhii-masaz-nig-45', 'Масаж ніг', 45, 600, 'Розслабляючий масаж, який повертає ногам легкість і комфорт.'),
                $this->fixed('serhii-miopresura-ruk-60', 'Міопресура рук', 60, 800, 'Ефективний масаж для тих, хто багато працює руками або відчуває напругу в кистях і передпліччях.'),
                $this->fixed('serhii-masaz-ruk-45', 'Масаж рук', 45, 500, 'Приємний розслабляючий масаж для відновлення рук після навантаження чи тривалої роботи.'),
                $this->fixed('serhii-vognianii-masaz-propraciuvannia-miaziv-45', 'Вогняний масаж з пропрацюванням м’язів', 45, 1200, 'Незвичайна процедура з потужним прогріваючим ефектом для глибокого розслаблення м’язів.'),
                $this->fixed('serhii-masaz-bleidami-45', 'Масаж блейдами', 45, 1000, 'Сучасна техніка масажу для глибокого опрацювання м’язів і фасцій.'),
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
                'Міостимуляція' => 'Міостимуляція- це процедура, яка за допомогою електроімпульсів змушує м’язи скорочуватись, як під час тренування. Допомагає підтягнути тіло, покращити тонус м’язів, кровообіг і зменшити прояви целюліту',
                'Ендосфера' => 'Одна з найпопулярніших процедур для боротьби з целюлітом та набряками. Після курсу шкіра стає більш гладенькою, а тіло — пружним і підтягнутим.',
                'Кавітація' => 'Ультразвук руйнує жирові клітини, допомагаючи зменшити обʼєми та покращити контури тіла.',
                'RF-ліфтинг' => 'Радіохвилі стимулюють вироблення колагену — шкіра стає більш підтягнутою та еластичною.',
                'Вакуумний масаж' => 'Глибоко опрацьовує тканини, покращує кровообіг і допомагає зменшити прояви целюліту.',
                'Пресотерапія' => 'Апаратна компресія стимулює лімфодренаж, допомагає зменшити набряки та втому ніг.',
                default => 'Апаратний масаж: ціна вказана за 1 хвилину. Тривалість клієнт обирає у формі запису.',
            },
        ], $items);
    }
}
