<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdMachine;
use App\Models\MdItem;
use App\Models\MdOperator;
use App\Models\MdDepartment;
use App\Models\MdLine;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * ITEM GUARDRAILS
         */
        $items = [
            'total' => MdItem::count(),
            'active' => MdItem::where('status', 'active')->count(),
            'inactive' => MdItem::where('status', 'inactive')->count(),
            'invalid_cycle' => MdItem::where('cycle_time_sec', '<=', 0)->count(),
        ];

        /**
         * MACHINE GUARDRAILS
         */
        $machines = [
            'total' => MdMachine::count(),
            'active' => MdMachine::where('status', 'active')->count(),
            'inactive' => MdMachine::where('status', 'inactive')->count(),
            'offline' => MdMachine::all()
                ->filter(fn($m) => in_array($m->computed_status, ['OFFLINE', 'STALE'], true))
                ->count(),
        ];

        /**
         * OPERATOR GUARDRAILS
         */
        $operators = [
            'total' => MdOperator::count(),
            'active' => MdOperator::where('status', 'active')->count(),
            'inactive' => MdOperator::where('status', 'inactive')->count(),
        ];

        /**
         * DEPARTMENT SUMMARY
         */
        $departments = [
            'total' => MdDepartment::count(),
        ];

        /**
         * 🔴 HEALTH CHECK DIMATIKAN TOTAL (WAJIB)
         */
        $healthWidget = [
            'inactive_items_used' => 0,
            'inactive_machines_used' => 0,
        ];

        $healthStatus = [
            'status' => 'disabled',
            'message' => 'Health check sementara dinonaktifkan',
        ];

        Log::warning('MASTER HEALTH CHECK FULLY DISABLED');

        // Machine Distribution for Doughnut Chart (Only non-zero)
        $machineDeptDist = MdDepartment::withCount('machines')
            ->get()
            ->filter(fn($d) => $d->machines_count > 0)
            ->values();

        // Operator Distribution for Doughnut Chart (Only non-zero)
        $operatorDeptDist = MdDepartment::withCount('operators')
            ->get()
            ->filter(fn($d) => $d->operators_count > 0)
            ->values();

        return view('master.dashboard.index', [
            'counts' => [
                'items_total' => $items['total'],
                'items_active' => $items['active'],
                'items_inactive' => $items['inactive'],
                'machines_total' => $machines['total'],
                'machines_active' => $machines['active'],
                'machines_inactive' => $machines['inactive'],
                'operators_total' => $operators['total'],
                'operators_active' => $operators['active'],
                'operators_inactive' => $operators['inactive'],
                'heat_numbers_total' => \App\Models\MdHeatNumber::count(),
                'heat_numbers_active' => \App\Models\MdHeatNumber::where('status', 'active')->count(),
                'lines_total' => MdLine::count(),
                'lines_active' => MdLine::where('status', 'active')->count(),
            ],
            'machineDeptDist' => $machineDeptDist,
            'operatorDeptDist' => $operatorDeptDist,
            'health' => $healthStatus,
        ]);
    }
}
