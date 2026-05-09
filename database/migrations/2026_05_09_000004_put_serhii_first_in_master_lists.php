<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('masters')->where('slug', 'serhii')->update(['sort_order' => 1]);
        DB::table('masters')->where('slug', 'olesia')->update(['sort_order' => 2]);
    }

    public function down(): void
    {
        DB::table('masters')->where('slug', 'olesia')->update(['sort_order' => 1]);
        DB::table('masters')->where('slug', 'serhii')->update(['sort_order' => 2]);
    }
};
