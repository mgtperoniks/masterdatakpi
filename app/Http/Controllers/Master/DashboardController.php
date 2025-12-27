<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdMachine;
use App\Models\MdItem;
use App\Models\MdOperator;
use App\Models\MdDepartment;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * ITEM GUARDRAILS
         */
        $items = [
            'total'            => MdItem::count(),
            'active'           => MdItem::where('status', 'active')->count(),
            'inactive'         => MdItem::where('status', 'inactive')->count(),
            'invalid_cycle'    => MdItem::where('cycle_time_sec', '<=', 0)->count(),
        ];

        /**
         * MACHINE GUARDRAILS
         */
        $machines = [
            'total'      => MdMachine::count(),
            'active'     => MdMachine::where('status', 'active')->count(),
            'inactive'   => MdMachine::where('status', 'inactive')->count(),
            'offline'    => MdMachine::get()
                ->filter(fn ($m) => in_array($m->computed_status, ['OFFLINE', 'STALE']))
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

        return view('master.dashboard.index', compact(
            'items',
            'machines',
            'operators',
            'departments'
        ));
    }
}
