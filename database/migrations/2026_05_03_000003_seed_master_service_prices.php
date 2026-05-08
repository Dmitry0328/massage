<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Historical data migration intentionally left empty.
        // The current public catalog is managed by later catalog sync migrations and seeders.
    }

    public function down(): void
    {
        //
    }
};
