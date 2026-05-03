<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('booking_settings')
            ->orderBy('id')
            ->get()
            ->each(function ($setting): void {
                $workingDays = json_decode((string) $setting->working_days, true) ?: [1, 2, 3, 4, 5, 6];

                if (! in_array(7, $workingDays, true)) {
                    $workingDays[] = 7;
                }

                sort($workingDays);

                DB::table('booking_settings')
                    ->where('id', $setting->id)
                    ->update([
                        'working_days' => json_encode(array_values($workingDays)),
                        'updated_at' => now(),
                    ]);
            });
    }

    public function down(): void
    {
        // Keep the admin-selected schedule unchanged on rollback.
    }
};
