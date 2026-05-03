<?php

use App\Models\Master;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->foreignId('master_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });

        $masters = Master::query()->orderBy('name')->get();

        if ($masters->isEmpty()) {
            return;
        }

        $firstMaster = $masters->first();
        $services = DB::table('services')->orderBy('id')->get();

        foreach ($services as $service) {
            DB::table('services')
                ->where('id', $service->id)
                ->update([
                    'master_id' => $firstMaster->id,
                    'updated_at' => now(),
                ]);
        }

        foreach ($masters->skip(1) as $master) {
            foreach ($services as $service) {
                DB::table('services')->insert([
                    'master_id' => $master->id,
                    'key' => "{$service->key}-master-{$master->id}",
                    'label' => $service->label,
                    'duration_minutes' => $service->duration_minutes,
                    'price' => $service->price,
                    'discount_percent' => $service->discount_percent,
                    'description' => $service->description,
                    'is_active' => $service->is_active,
                    'sort_order' => $service->sort_order,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('master_id');
        });
    }
};
