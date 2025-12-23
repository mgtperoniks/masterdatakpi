<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('md_lines', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('department_code', 20);
            $table->string('name', 100);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('department_code')
                ->references('code')
                ->on('md_departments')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->index(['department_code', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('md_lines');
    }
};
