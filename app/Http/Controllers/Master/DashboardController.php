<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdMachine;
use App\Models\MdItem;
use App\Models\MdOperator;
use App\Models\MdDepartment;
use App\Services\MasterHealthService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(MasterHealthService $healthService)
    {
        /**
         * ITEM GUARDRAILS
         */
        $items = [
            'total'         => MdItem::count(),
            'active'        => MdItem::where('status', 'active')->count(),
            'inactive'      => MdItem::where('status', 'inactive')->count(),
            'invalid_cycle' => MdItem::where('cycle_time_sec', '<=', 0)->count(),
        ];

        /**
         * MACHINE GUARDRAILS
         */
        $machines = [
            'total'    => MdMachine::count(),
            'active'   => MdMachine::where('status', 'active')->count(),
            'inactive' => MdMachine::where('status', 'inactive')->count(),
            'offline'  => MdMachine::all()
                ->filter(fn ($m) => in_array($m->computed_status, ['OFFLINE', 'STALE'], true))
                ->count(),
        ];

        /**
         * OPERATOR GUARDRAILS
         */
        $operators = [
            'total'    => MdOperator::count(),
            'active'   => MdOperator::where('status', 'active')->count(),
            'inactive' => MdOperator::where('status', 'inactive')->count(),
        ];

        /**
         * DEPARTMENT SUMMARY
         */
        $departments = [
            'total' => MdDepartment::count(),
        ];

        /**
         * MASTERDATA KPI — HEALTH WIDGET (READ-ONLY)
         */
        $healthWidget = [
            'inactive_items_used' => DB::connection('master')
                ->table('production_logs')
                ->whereIn('item_code', function ($q) {
                    $q->select('code')
                        ->from('md_items')
                        ->where('status', 'inactive');
                })
                ->count(),

            'inactive_machines_used' => DB::connection('master')
                ->table('production_logs')
                ->whereIn('machine_code', function ($q) {
                    $q->select('code')
                        ->from('md_machines')
                        ->where('status', 'inactive');
                })
                ->count(),
        ];

        /**
         * MASTER HEALTH CHECK (SERVICE)
         */
        $healthStatus = $healthService->check();

        return view('master.dashboard.index', [
            'items'        => $items,
            'machines'     => $machines,
            'operators'    => $operators,
            'departments'  => $departments,
            'health'       => $healthStatus,
            'healthWidget' => $healthWidget,
        ]);
    }
}
