<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_overrides', function (Blueprint $table): void {
            $table->id();
            $table->string('page_key')->default('home')->index();
            $table->text('selector');
            $table->string('selector_hash', 64);
            $table->string('type', 20);
            $table->string('original_hash', 80)->nullable();
            $table->longText('value');
            $table->json('meta')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['page_key', 'selector_hash', 'type', 'original_hash'], 'content_overrides_unique_target');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_overrides');
    }
};
