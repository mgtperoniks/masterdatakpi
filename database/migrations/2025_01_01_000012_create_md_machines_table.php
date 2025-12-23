<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('md_machines', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name', 100);
            $table->string('department_code', 20);
            $table->string('line_code', 20)->nullable();
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');

            $table->timestamp('last_seen_at')->nullable();
            $table->string('last_active_module', 50)->nullable();
            $table->timestamp('last_sync_at')->nullable();

            $table->timestamps();

            $table->foreign('department_code')
                ->references('code')
                ->on('md_departments')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreign('line_code')
                ->references('code')
                ->on('md_lines')
                ->nullOnDelete();

            $table->index(['department_code', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('md_machines');
    }
};
