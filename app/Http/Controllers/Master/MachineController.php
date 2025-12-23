<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MdMachine;
use App\Models\MdDepartment;
use App\Models\MdLine;
use App\Traits\Auditable;

class MachineController extends Controller
{
    use Auditable;

    public function index()
    {
        $machines = MdMachine::with(['department', 'line'])
            ->orderBy('code')
            ->get();

        return view('master.machines.index', compact('machines'));
    }

    public function create()
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        $lines = MdLine::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.machines.create', compact('departments', 'lines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|string|max:30|unique:md_machines,code',
            'name'            => 'required|string|max:100',
            'department_code' => 'required|exists:md_departments,code',
            'line_code'       => 'nullable|exists:md_lines,code',
            'status'          => 'required|in:active,maintenance,inactive',
        ]);

        $machine = MdMachine::create(
            $request->only([
                'code',
                'name',
                'department_code',
                'line_code',
                'status',
            ])
        );

        $this->audit(
            'md_machines',
            $machine->code,
            'create',
            'master',
            'Create machine'
        );

        return redirect()
            ->route('master.machines.index')
            ->with('success', 'Machine created successfully');
    }

    public function edit($id)
    {
        $machine = MdMachine::findOrFail($id);

        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        $lines = MdLine::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.machines.edit', compact('machine', 'departments', 'lines'));
    }

    public function update(Request $request, $id)
    {
        $machine = MdMachine::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:100',
            'department_code' => 'required|exists:md_departments,code',
            'line_code'       => 'nullable|exists:md_lines,code',
            'status'          => 'required|in:active,maintenance,inactive',
        ]);

        $machine->update(
            $request->only([
                'name',
                'department_code',
                'line_code',
                'status',
            ])
        );

        $this->audit(
            'md_machines',
            $machine->code,
            'update',
            'master',
            'Update machine'
        );

        return redirect()
            ->route('master.machines.index')
            ->with('success', 'Machine updated successfully');
    }
}
