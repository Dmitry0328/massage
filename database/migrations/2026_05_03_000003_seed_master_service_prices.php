<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $masters = DB::table('masters')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        if ($masters->isEmpty()) {
            return;
        }

        $olesia = $masters->first(fn ($master): bool => str_contains(mb_strtolower($master->name), 'олеся'))
            ?? $masters->first();
        $serhii = $masters->first(fn ($master): bool => str_contains(mb_strtolower($master->name), 'сергі'))
            ?? $masters->skip(1)->first()
            ?? $olesia;

        $this->replaceServices((int) $olesia->id, 'olesia', [
            ['Загальний масаж тіла', 120, 800, 'Повний масаж тіла для глибокого розслаблення та відновлення.'],
            ['Класичний масаж (будь яка одна зона)', 45, 500, 'Класичний масаж однієї обраної зони.'],
            ['Лімфодренаж', 45, 600, 'Лімфодренажний масаж для легкості та зменшення набряклості.'],
            ['Медовий масаж', 45, 700, 'Медовий масаж для тонусу шкіри та активного опрацювання тканин.'],
            ['Масаж обличчя', 45, 500, 'Масаж обличчя для розслаблення, тонусу та свіжого вигляду.'],
            ...$this->apparatusServices(),
        ]);

        if ((int) $serhii->id !== (int) $olesia->id) {
            $this->replaceServices((int) $serhii->id, 'serhii', [
                ['Міопресура', 60, 700, 'Точкова робота з мʼязовою напругою та глибокими зонами.'],
                ['Загальний масаж всього тіла', 120, 1400, 'Повний масаж всього тіла для відновлення та розслаблення.'],
                ['Класичний масаж (будь яка зона)', 60, 700, 'Класичний масаж однієї обраної зони.'],
                ['Вогняний масаж', 60, 900, 'Інтенсивна процедура з тепловим ефектом.'],
                ['Баночний масаж', 60, 500, 'Баночний масаж для активного опрацювання тканин.'],
                ...$this->apparatusServices(),
            ]);
        }
    }

    public function down(): void
    {
        // This migration intentionally seeds current business data.
    }

    private function replaceServices(int $masterId, string $masterKey, array $services): void
    {
        DB::table('services')
            ->where('master_id', $masterId)
            ->delete();

        $now = now();

        foreach (array_values($services) as $index => $service) {
            [$label, $duration, $price, $description] = $service;

            DB::table('services')->insert([
                'master_id' => $masterId,
                'key' => $this->serviceKey($masterKey, $label, (int) $duration),
                'label' => $label,
                'duration_minutes' => (int) $duration,
                'price' => (int) $price,
                'discount_percent' => 0,
                'description' => $description,
                'is_active' => true,
                'sort_order' => $index + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function apparatusServices(): array
    {
        $names = [
            'Міостимуляція',
            'Кавітація',
            'RF-ліфтинг',
            'Вакуумний масаж',
            'Пресотерапія',
        ];
        $durations = [15, 30, 45, 60];
        $services = [];

        foreach ($names as $name) {
            foreach ($durations as $duration) {
                $services[] = [
                    "{$name} {$duration} хв",
                    $duration,
                    $duration * 10,
                    "Апаратний масаж: 10 грн за 1 хв. Обраний час: {$duration} хв.",
                ];
            }
        }

        return $services;
    }

    private function serviceKey(string $masterKey, string $label, int $duration): string
    {
        return Str::slug("{$masterKey} {$label} {$duration}") ?: "{$masterKey}-service-{$duration}";
    }
};
