<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedule_blocks', function (Blueprint $table): void {
            $table->dropForeign(['master_id']);
            $table->foreignId('master_id')->nullable()->change();
            $table->foreign('master_id')->references('id')->on('masters')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('schedule_blocks', function (Blueprint $table): void {
            $table->dropForeign(['master_id']);
            $table->foreignId('master_id')->nullable(false)->change();
            $table->foreign('master_id')->references('id')->on('masters')->cascadeOnDelete();
        });
    }
};
