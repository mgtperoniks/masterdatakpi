<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('md_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('table_name', 50);
            $table->string('record_code', 50);
            $table->enum('action', ['create', 'update', 'deactivate', 'sync']);
            $table->enum('source', ['master', 'module']);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['table_name', 'record_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('md_audit_logs');
    }
};
