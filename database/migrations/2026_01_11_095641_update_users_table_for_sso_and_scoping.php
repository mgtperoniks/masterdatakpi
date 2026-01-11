<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('department_code', 20)->nullable()->after('scope');
            $table->json('allowed_apps')->nullable()->after('department_code');

            $table->foreign('department_code')->references('code')->on('md_departments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_code']);
            $table->dropColumn(['department_code', 'allowed_apps']);
        });
    }
};
