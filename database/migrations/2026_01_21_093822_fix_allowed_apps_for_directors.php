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
        $users = ['direktur@peroniks.com', 'mr@peroniks.com'];

        foreach ($users as $email) {
            $user = \App\Models\User::where('email', $email)->first();
            if ($user) {
                // Ensure array, merge if exists, but for this fix just strict set is safer
                // or array_unique merge.
                $currentApps = $user->allowed_apps ?? [];
                if (!in_array('masterdata-kpi', $currentApps)) {
                    $currentApps[] = 'masterdata-kpi';
                }
                if (!in_array('kpi-bubut', $currentApps)) {
                    $currentApps[] = 'kpi-bubut';
                }

                $user->allowed_apps = $currentApps;
                $user->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
