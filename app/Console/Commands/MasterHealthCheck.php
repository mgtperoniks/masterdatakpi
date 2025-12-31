<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterHealthCheck extends Command
{
    protected $signature = 'master:health-check';

    protected $description = 'Scan master mirror vs KPI usage and log health drift';

    public function handle()
    {
        $now = now();

        /**
         * =====================================
         * A. INACTIVE MASTER USED BY KPI
         * =====================================
         */
        $inactiveItemsUsed = DB::connection('kpi')
            ->table('production_logs')
            ->whereIn('item_code', function ($q) {
                $q->select('code')
                    ->from('md_items')
                    ->where('status', 'inactive');
            })
            ->count();

        $inactiveMachinesUsed = DB::connection('kpi')
            ->table('production_logs')
            ->whereIn('machine_code', function ($q) {
                $q->select('code')
                    ->from('md_machines')
                    ->where('status', 'inactive');
            })
            ->count();

        $inactiveOperatorsUsed = DB::connection('kpi')
            ->table('production_logs')
            ->whereIn('operator_code', function ($q) {
                $q->select('code')
                    ->from('md_operators')
                    ->where('status', 'inactive');
            })
            ->count();

        /**
         * =====================================
         * B. MIRROR STALE CHECK
         * =====================================
         */
        $staleThreshold = $now->copy()->subHours(24);

        $staleMirrors = [
            'items' => DB::table('md_items')
                ->where(function ($q) use ($staleThreshold) {
                    $q->whereNull('last_sync_at')
                      ->orWhere('last_sync_at', '<', $staleThreshold);
                })
                ->count(),

            'machines' => DB::table('md_machines')
                ->where(function ($q) use ($staleThreshold) {
                    $q->whereNull('last_sync_at')
                      ->orWhere('last_sync_at', '<', $staleThreshold);
                })
                ->count(),

            'operators' => DB::table('md_operators')
                ->where(function ($q) use ($staleThreshold) {
                    $q->whereNull('last_sync_at')
                      ->orWhere('last_sync_at', '<', $staleThreshold);
                })
                ->count(),
        ];

        /**
         * =====================================
         * C. LOG KE AUDIT TABLE
         * =====================================
         */
        DB::table('md_audit_logs')->insert([
            'type'       => 'health',
            'payload'    => json_encode([
                'inactive_used' => [
                    'items'     => $inactiveItemsUsed,
                    'machines'  => $inactiveMachinesUsed,
                    'operators' => $inactiveOperatorsUsed,
                ],
                'stale_mirror' => $staleMirrors,
            ]),
            'created_at' => $now,
        ]);

        $this->info('Master health check completed');

        return Command::SUCCESS;
    }
}
