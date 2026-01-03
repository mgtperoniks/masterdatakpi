<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdMachine;
use App\Models\MdItem;
use App\Models\MdOperator;
use App\Models\MdDepartment;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
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
         * 🔴 HEALTH CHECK DIMATIKAN TOTAL (WAJIB)
         */
        $healthWidget = [
            'inactive_items_used'    => 0,
            'inactive_machines_used' => 0,
        ];

        $healthStatus = [
            'status'  => 'disabled',
            'message' => 'Health check sementara dinonaktifkan',
        ];

        Log::warning('MASTER HEALTH CHECK FULLY DISABLED');

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
