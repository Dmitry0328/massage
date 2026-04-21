<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_id')->constrained()->cascadeOnDelete();
            $table->string('client_name');
            $table->string('phone');
            $table->string('service');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('social_contact')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending');
            $table->string('source')->default('website');
            $table->timestamps();

            $table->index(['master_id', 'appointment_date']);
            $table->index(['master_id', 'appointment_date', 'appointment_time'], 'appointments_slot_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
