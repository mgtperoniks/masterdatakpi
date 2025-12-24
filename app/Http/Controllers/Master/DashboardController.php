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
        $summary = [
            'machines' => [
                'total' => MdMachine::count(),
                'active' => MdMachine::where('status', 'active')->count(),
                'inactive' => MdMachine::where('status', '!=', 'active')->count(),
            ],
            'items' => [
                'total' => MdItem::count(),
                'active' => MdItem::where('status', 'active')->count(),
                'inactive' => MdItem::where('status', '!=', 'active')->count(),
            ],
            'operators' => [
                'total' => MdOperator::count(),
                'active' => MdOperator::where('status', 'active')->count(),
                'inactive' => MdOperator::where('status', '!=', 'active')->count(),
            ],
            'departments' => [
                'total' => MdDepartment::count(),
            ],
        ];

        return view('dashboard.index', compact('summary'));
    }
}
