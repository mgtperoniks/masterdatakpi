<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('md_heat_numbers', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('kode_produksi', 50)->nullable();
            $blueprint->string('item_code', 50);
            $blueprint->string('item_name', 200)->nullable();
            $blueprint->string('heat_number', 50)->unique();
            $blueprint->integer('cor_qty')->default(0);
            $blueprint->string('status', 20)->default('active');
            $blueprint->timestamps();

            // Indexing for faster sync/search
            $blueprint->index('item_code');
            $blueprint->index('heat_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_heat_numbers');
    }
};
