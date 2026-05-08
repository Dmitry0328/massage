<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_settings', function (Blueprint $table): void {
            $table->boolean('show_quick_book_block')->default(false)->after('slot_step_minutes');
        });
    }

    public function down(): void
    {
        Schema::table('booking_settings', function (Blueprint $table): void {
            $table->dropColumn('show_quick_book_block');
        });
    }
};
