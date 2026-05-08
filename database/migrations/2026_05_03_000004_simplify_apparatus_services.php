<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            if (! Schema::hasColumn('services', 'category')) {
                $table->string('category')->nullable()->after('label');
            }

            if (! Schema::hasColumn('services', 'is_price_per_minute')) {
                $table->boolean('is_price_per_minute')->default(false)->after('price');
            }
        });

        Schema::table('appointments', function (Blueprint $table): void {
            if (! Schema::hasColumn('appointments', 'service_durations')) {
                $table->json('service_durations')->nullable()->after('additional_services');
            }
        });

        $apparatusNames = [
            'Міостимуляція',
            'ЕНДОСФЕРА',
            'Кавітація',
            'RF-ліфтинг',
            'RF- ліфтинг',
            'Вакуумний масаж',
            'Пресотерапія',
        ];

        $masters = DB::table('services')
            ->select('master_id')
            ->whereNotNull('master_id')
            ->distinct()
            ->pluck('master_id');

        foreach ($masters as $masterId) {
            $processedLabels = [];

            foreach ($apparatusNames as $name) {
                $displayName = $name === 'RF-ліфтинг' ? 'RF- ліфтинг' : $name;

                if (in_array($displayName, $processedLabels, true)) {
                    continue;
                }

                $existingRows = DB::table('services')
                    ->where('master_id', $masterId)
                    ->where(function ($query) use ($name): void {
                        $query
                            ->where('label', $name)
                            ->orWhere('label', 'like', "{$name} %");
                    })
                    ->get();

                if ($existingRows->isEmpty()) {
                    continue;
                }

                $processedLabels[] = $displayName;
                $first = $existingRows->first();
                $minutePrice = $this->resolveMinutePrice($existingRows);

                DB::table('services')
                    ->where('master_id', $masterId)
                    ->where(function ($query) use ($name): void {
                        $query
                            ->where('label', $name)
                            ->orWhere('label', 'like', "{$name} %");
                    })
                    ->delete();

                DB::table('services')->insert([
                    'master_id' => $masterId,
                    'key' => $this->serviceKey((int) $masterId, $displayName),
                    'label' => $displayName,
                    'category' => 'Апаратні масажі',
                    'duration_minutes' => 60,
                    'price' => $minutePrice,
                    'is_price_per_minute' => true,
                    'discount_percent' => 0,
                    'description' => 'Апаратний масаж: ціна вказана за 1 хвилину. Тривалість клієнт обирає у формі запису.',
                    'is_active' => (bool) ($first->is_active ?? true),
                    'sort_order' => (int) ($first->sort_order ?? 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->moveAppointmentsToBaseService($existingRows, $this->serviceKey((int) $masterId, $displayName));
            }
        }
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table): void {
            if (Schema::hasColumn('appointments', 'service_durations')) {
                $table->dropColumn('service_durations');
            }
        });

        Schema::table('services', function (Blueprint $table): void {
            if (Schema::hasColumn('services', 'is_price_per_minute')) {
                $table->dropColumn('is_price_per_minute');
            }

            if (Schema::hasColumn('services', 'category')) {
                $table->dropColumn('category');
            }
        });
    }

    private function resolveMinutePrice($rows): int
    {
        foreach ($rows as $row) {
            $duration = max((int) ($row->duration_minutes ?? 0), 1);
            $price = (int) ($row->price ?? 0);

            if ((bool) ($row->is_price_per_minute ?? false) && $price > 0) {
                return $price;
            }

            if ($price > 0) {
                return max((int) round($price / $duration), 1);
            }
        }

        return 10;
    }

    private function serviceKey(int $masterId, string $label): string
    {
        return Str::slug("master {$masterId} {$label}") ?: "master-{$masterId}-apparatus";
    }

    private function moveAppointmentsToBaseService($oldServices, string $baseKey): void
    {
        $oldServicesByKey = $oldServices->keyBy('key');

        DB::table('appointments')
            ->whereIn('service', $oldServicesByKey->keys()->all())
            ->orderBy('id')
            ->get()
            ->each(function ($appointment) use ($oldServicesByKey, $baseKey): void {
                $oldService = $oldServicesByKey->get($appointment->service);
                $durations = json_decode((string) ($appointment->service_durations ?? '[]'), true) ?: [];
                $durations[$baseKey] = (int) ($oldService->duration_minutes ?? 60);

                DB::table('appointments')
                    ->where('id', $appointment->id)
                    ->update([
                        'service' => $baseKey,
                        'service_durations' => json_encode($durations, JSON_UNESCAPED_UNICODE),
                        'updated_at' => now(),
                    ]);
            });

        DB::table('appointments')
            ->whereNotNull('additional_services')
            ->orderBy('id')
            ->get()
            ->each(function ($appointment) use ($oldServicesByKey, $baseKey): void {
                $additionalServices = json_decode((string) $appointment->additional_services, true) ?: [];
                $durations = json_decode((string) ($appointment->service_durations ?? '[]'), true) ?: [];
                $changed = false;

                foreach ($additionalServices as $index => $serviceKey) {
                    if (! $oldServicesByKey->has($serviceKey)) {
                        continue;
                    }

                    $oldService = $oldServicesByKey->get($serviceKey);
                    $additionalServices[$index] = $baseKey;
                    $durations[$baseKey] = (int) ($oldService->duration_minutes ?? 60);
                    $changed = true;
                }

                if (! $changed) {
                    return;
                }

                DB::table('appointments')
                    ->where('id', $appointment->id)
                    ->update([
                        'additional_services' => json_encode(array_values(array_unique($additionalServices)), JSON_UNESCAPED_UNICODE),
                        'service_durations' => json_encode($durations, JSON_UNESCAPED_UNICODE),
                        'updated_at' => now(),
                    ]);
            });
    }
};
