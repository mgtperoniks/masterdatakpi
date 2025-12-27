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

    /**
     * Display a listing of machines.
     */
    public function index()
    {
        $machines = MdMachine::with(['department', 'line'])
            ->orderBy('code')
            ->get();

        return view('master.machines.index', compact('machines'));
    }

    /**
     * Show the form for creating a new machine.
     */
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

    /**
     * Store a newly created machine.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'            => 'required|string|max:50|unique:md_machines,code',
            'name'            => 'required|string|max:150',
            'department_code' => 'required|exists:md_departments,code',
            'line_code'       => 'nullable|exists:md_lines,code',
            'status'          => 'required|in:active,maintenance,inactive',
        ]);

        $machine = MdMachine::create($validated);

        $this->audit(
            'md_machines',
            $machine->code,
            'create',
            'master',
            'Create machine'
        );

        return redirect()
            ->route('master.machines.index')
            ->with('success', 'Machine berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified machine.
     */
    public function edit(MdMachine $machine)
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        $lines = MdLine::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.machines.edit', compact('machine', 'departments', 'lines'));
    }

    /**
     * Update the specified machine.
     */
    public function update(Request $request, MdMachine $machine)
    {
        $validated = $request->validate([
            'code'            => 'required|string|max:50|unique:md_machines,code,' . $machine->id,
            'name'            => 'required|string|max:150',
            'department_code' => 'required|exists:md_departments,code',
            'line_code'       => 'nullable|exists:md_lines,code',
            'status'          => 'required|in:active,maintenance,inactive',
        ]);

        $machine->update($validated);

        $this->audit(
            'md_machines',
            $machine->code,
            'update',
            'master',
            'Update machine'
        );

        return redirect()
            ->route('master.machines.index')
            ->with('success', 'Machine berhasil diperbarui.');
    }
}
