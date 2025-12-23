<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MdDepartment;
use App\Traits\Auditable;

class DepartmentController extends Controller
{
    use Auditable;

    public function index()
    {
        $departments = MdDepartment::orderBy('code')->get();

        return view('master.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('master.departments.create');
    }

    /**
     * Store new department
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'   => 'required|string|max:20|unique:md_departments,code',
            'name'   => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        // CREATE
        $department = MdDepartment::create(
            $request->only(['code', 'name', 'status'])
        );

        // AUDIT
        $this->audit(
            'md_departments',
            $department->code,
            'create',
            'master',
            'Create department'
        );

        return redirect()
            ->route('master.departments.index')
            ->with('success', 'Department created successfully');
    }

    public function edit($id)
    {
        $department = MdDepartment::findOrFail($id);

        return view('master.departments.edit', compact('department'));
    }

    /**
     * Update department
     */
    public function update(Request $request, $id)
    {
        $department = MdDepartment::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        // UPDATE
        $department->update(
            $request->only(['name', 'status'])
        );

        // AUDIT
        $this->audit(
            'md_departments',
            $department->code,
            'update',
            'master',
            'Update department'
        );

        return redirect()
            ->route('master.departments.index')
            ->with('success', 'Department updated successfully');
    }
}
