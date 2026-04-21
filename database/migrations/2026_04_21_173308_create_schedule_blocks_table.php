<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_id')->constrained()->cascadeOnDelete();
            $table->date('block_date');
            $table->boolean('is_full_day')->default(false);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            $table->index(['master_id', 'block_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_blocks');
    }
};
