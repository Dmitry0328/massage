<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('master_id')->constrained()->cascadeOnDelete();
            $table->string('client_name');
            $table->string('phone');
            $table->text('message')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_requests');
    }
};
