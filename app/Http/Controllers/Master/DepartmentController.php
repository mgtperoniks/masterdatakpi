<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MdDepartment;
use App\Traits\Auditable;

class DepartmentController extends Controller
{
    use Auditable;

    /**
     * Display a listing of departments.
     * Index tampil ACTIVE & INACTIVE
     */
    public function index()
    {
        $departments = MdDepartment::orderBy('code')->get();

        return view('master.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('master.departments.create');
    }

    /**
     * Store new department.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'   => 'required|string|max:20|unique:md_departments,code',
            'name'   => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $department = MdDepartment::create($validated);

        $this->audit(
            'md_departments',
            $department->code,
            'create',
            'master',
            'Create department'
        );

        return redirect()
            ->route('master.departments.index')
            ->with('success', 'Department berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(MdDepartment $department)
    {
        return view('master.departments.edit', compact('department'));
    }

    /**
     * Update department.
     */
    public function update(Request $request, MdDepartment $department)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $department->update($validated);

        $this->audit(
            'md_departments',
            $department->code,
            'update',
            'master',
            'Update department'
        );

        return redirect()
            ->route('master.departments.index')
            ->with('success', 'Department berhasil diperbarui.');
    }

    /**
     * Deactivate department (NO DELETE)
     */
    public function deactivate(MdDepartment $department)
    {
        $department->update([
            'status' => 'inactive',
        ]);

        $this->audit(
            'md_departments',
            $department->code,
            'deactivate',
            'master',
            'Deactivate department'
        );

        return back()->with('success', 'Department dinonaktifkan.');
    }

    /**
     * Activate department
     */
    public function activate(MdDepartment $department)
    {
        $department->update([
            'status' => 'active',
        ]);

        $this->audit(
            'md_departments',
            $department->code,
            'activate',
            'master',
            'Activate department'
        );

        return back()->with('success', 'Department diaktifkan kembali.');
    }
}
