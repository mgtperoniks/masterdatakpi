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
     * Support: search, filter, pagination
     */
    public function index(Request $request)
    {
        $query = MdMachine::with(['department', 'line']);

        // 🔍 Search code / name
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            });
        }

        // 🏭 Filter Department
        if ($request->filled('department_code')) {
            $query->where('department_code', $request->department_code);
        }

        // 🔄 Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $machines = $query
            ->orderBy('code')
            ->paginate(20)        // ✅ pagination
            ->withQueryString(); // ✅ jaga query saat pindah halaman

        $departments = MdDepartment::orderBy('code')->get();

        return view(
            'master.machines.index',
            compact('machines', 'departments')
        );
    }

    /**
     * Show the form for creating a new machine.
     * Dropdown hanya ACTIVE (hard guard)
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
            'status'          => 'required|in:active,inactive',
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

        return view(
            'master.machines.edit',
            compact('machine', 'departments', 'lines')
        );
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
            'status'          => 'required|in:active,inactive',
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

    /**
     * Deactivate machine (NO DELETE)
     */
    public function deactivate(MdMachine $machine)
    {
        $machine->update([
            'status' => 'inactive',
        ]);

        $this->audit(
            'md_machines',
            $machine->code,
            'deactivate',
            'master',
            'Deactivate machine'
        );

        return back()->with('success', 'Machine dinonaktifkan.');
    }

    /**
     * Activate machine
     */
    public function activate(MdMachine $machine)
    {
        $machine->update([
            'status' => 'active',
        ]);

        $this->audit(
            'md_machines',
            $machine->code,
            'activate',
            'master',
            'Activate machine'
        );

        return back()->with('success', 'Machine diaktifkan kembali.');
    }
}
