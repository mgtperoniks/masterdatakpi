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
        Schema::table('md_audit_logs', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            $table->string('ip_address', 45)->nullable()->after('source');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->json('old_values')->nullable()->after('user_agent');
            $table->json('new_values')->nullable()->after('old_values');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('md_audit_logs', function (Blueprint $table) {
            //
        });
    }
};
