<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('md_heat_numbers', function (Blueprint $table) {
            $table->date('heat_date')->nullable()->after('kode_produksi');
            $table->index('heat_date');
        });

        // Backfill existing records with created_at date
        DB::table('md_heat_numbers')
            ->whereNull('heat_date')
            ->update(['heat_date' => DB::raw('DATE(created_at)')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('md_heat_numbers', function (Blueprint $table) {
            $table->dropIndex(['heat_date']);
            $table->dropColumn('heat_date');
        });
    }
};
