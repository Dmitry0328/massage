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
        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->unsignedInteger('duration_minutes')->default(60);
            $table->unsignedInteger('price')->default(0);
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        $sortOrder = 0;

        $services = collect(config('booking.services', []))
            ->map(function (array $service, string $key) use ($now, &$sortOrder): array {
                $label = (string) ($service['label'] ?? 'Послуга');
                $badge = (string) ($service['badge'] ?? '');
                $sortOrder++;

                return [
                    'key' => $key ?: (Str::slug($label) ?: 'service'),
                    'label' => $label,
                    'duration_minutes' => (int) (preg_replace('/[^\d]/', '', (string) ($service['duration'] ?? '60')) ?: 60),
                    'price' => (int) ($service['price'] ?? 0),
                    'discount_percent' => (int) (preg_replace('/[^\d]/', '', $badge) ?: 0),
                    'description' => $service['description'] ?? null,
                    'is_active' => true,
                    'sort_order' => $sortOrder,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })
            ->values()
            ->all();

        if ($services) {
            DB::table('services')->insert($services);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
