<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_settings', function (Blueprint $table): void {
            $table->json('working_days')->nullable()->after('max_advance_months');
            $table->time('work_start_time')->default('10:00')->after('working_days');
            $table->time('work_end_time')->default('18:00')->after('work_start_time');
            $table->unsignedSmallInteger('slot_step_minutes')->default(60)->after('work_end_time');
        });
    }

    public function down(): void
    {
        Schema::table('booking_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'working_days',
                'work_start_time',
                'work_end_time',
                'slot_step_minutes',
            ]);
        });
    }
};
