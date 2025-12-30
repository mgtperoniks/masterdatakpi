<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('md_operators', function (Blueprint $table) {

            // sequence kerja (reuse code)
            $table->unsignedInteger('employment_seq')
                  ->default(1)
                  ->after('code');

            // lifecycle tanggal
            $table->date('active_from')
                  ->nullable()
                  ->after('employment_seq');

            $table->date('active_until')
                  ->nullable()
                  ->after('active_from');

            // kombinasi unik (kode + seq)
            $table->unique(['code', 'employment_seq'], 'uniq_operator_code_seq');
        });
    }

    public function down(): void
    {
        Schema::table('md_operators', function (Blueprint $table) {
            $table->dropUnique('uniq_operator_code_seq');
            $table->dropColumn([
                'employment_seq',
                'active_from',
                'active_until',
            ]);
        });
    }
};
