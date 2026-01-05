<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('md_operators', function (Blueprint $table) {

            // HR basic info
            $table->date('join_date')
                  ->nullable()
                  ->after('name');

            $table->string('position', 100)
                  ->nullable()
                  ->after('join_date');

            $table->enum('gender', ['male', 'female'])
                  ->nullable()
                  ->after('position');

            $table->enum('employment_type', ['PKWT', 'PKWTT', 'OUTSOURCE'])
                  ->nullable()
                  ->after('gender');

            // lifecycle deactivate
            $table->date('inactive_at')
                  ->nullable()
                  ->after('status');

            $table->text('inactive_reason')
                  ->nullable()
                  ->after('inactive_at');
        });
    }

    public function down(): void
    {
        Schema::table('md_operators', function (Blueprint $table) {
            $table->dropColumn([
                'join_date',
                'position',
                'gender',
                'employment_type',
                'inactive_at',
                'inactive_reason',
            ]);
        });
    }
};
