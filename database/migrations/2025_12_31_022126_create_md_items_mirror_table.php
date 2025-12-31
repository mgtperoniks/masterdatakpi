<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('md_items_mirror', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name');
            $table->integer('cycle_time_sec');

            // lifecycle
            $table->enum('status', ['active', 'inactive'])->default('active');

            // sync metadata
            $table->timestamp('source_updated_at')->nullable();
            $table->timestamp('last_sync_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('md_items_mirror');
    }
};
