<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('md_operators_mirror', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->string('department_code');

            // lifecycle
            $table->unsignedInteger('employment_seq')->default(1);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->dateTime('active_from')->nullable();
            $table->dateTime('inactive_at')->nullable();

            // sync metadata
            $table->timestamp('source_updated_at')->nullable();
            $table->timestamp('last_sync_at')->nullable();

            $table->timestamps();

            // composite unique
            $table->unique(['code', 'employment_seq']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('md_operators_mirror');
    }
};
