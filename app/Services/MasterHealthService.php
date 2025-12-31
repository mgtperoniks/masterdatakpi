<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MasterHealthService
{
    public function check(): array
    {
        return [
            'inactive_used' => $this->inactiveUsed(),
            'orphan_refs'   => $this->orphanReferences(),
            'duplicate_actives' => $this->duplicateActives(),
        ];
    }

    protected function inactiveUsed(): array
    {
        return [
            'items' => DB::table('md_items')
                ->where('status', 'inactive')
                ->whereIn('code', function ($q) {
                    $q->select('item_code')->from('production_logs');
                })->count(),

            'operators' => DB::table('md_operators')
                ->where('status', 'inactive')
                ->whereIn('code', function ($q) {
                    $q->select('operator_code')->from('production_logs');
                })->count(),

            'machines' => DB::table('md_machines')
                ->where('status', 'inactive')
                ->whereIn('code', function ($q) {
                    $q->select('machine_code')->from('production_logs');
                })->count(),
        ];
    }

    protected function orphanReferences(): array
    {
        return [
            'items' => DB::table('production_logs')
                ->whereNotIn('item_code', function ($q) {
                    $q->select('code')->from('md_items');
                })->distinct()->count('item_code'),

            'operators' => DB::table('production_logs')
                ->whereNotIn('operator_code', function ($q) {
                    $q->select('code')->from('md_operators');
                })->distinct()->count('operator_code'),

            'machines' => DB::table('production_logs')
                ->whereNotIn('machine_code', function ($q) {
                    $q->select('code')->from('md_machines');
                })->distinct()->count('machine_code'),
        ];
    }

    protected function duplicateActives(): array
    {
        return [
            'items' => DB::table('md_items')
                ->where('status', 'active')
                ->groupBy('code')
                ->havingRaw('COUNT(*) > 1')
                ->count(),

            'operators' => DB::table('md_operators')
                ->where('status', 'active')
                ->groupBy('code')
                ->havingRaw('COUNT(*) > 1')
                ->count(),

            'machines' => DB::table('md_machines')
                ->where('status', 'active')
                ->groupBy('code')
                ->havingRaw('COUNT(*) > 1')
                ->count(),
        ];
    }
}
