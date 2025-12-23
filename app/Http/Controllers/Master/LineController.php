<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MdLine;
use App\Models\MdDepartment;
use App\Traits\Auditable;

class LineController extends Controller
{
    use Auditable;

    public function index()
    {
        $lines = MdLine::with('department')
            ->orderBy('code')
            ->get();

        return view('master.lines.index', compact('lines'));
    }

    public function create()
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.lines.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|string|max:20|unique:md_lines,code',
            'department_code' => 'required|exists:md_departments,code',
            'name'            => 'required|string|max:100',
            'status'          => 'required|in:active,inactive',
        ]);

        $line = MdLine::create(
            $request->only(['code', 'department_code', 'name', 'status'])
        );

        $this->audit(
            'md_lines',
            $line->code,
            'create',
            'master',
            'Create line'
        );

        return redirect()
            ->route('master.lines.index')
            ->with('success', 'Line created successfully');
    }

    public function edit($id)
    {
        $line = MdLine::findOrFail($id);

        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.lines.edit', compact('line', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $line = MdLine::findOrFail($id);

        $request->validate([
            'department_code' => 'required|exists:md_departments,code',
            'name'            => 'required|string|max:100',
            'status'          => 'required|in:active,inactive',
        ]);

        $line->update(
            $request->only(['department_code', 'name', 'status'])
        );

        $this->audit(
            'md_lines',
            $line->code,
            'update',
            'master',
            'Update line'
        );

        return redirect()
            ->route('master.lines.index')
            ->with('success', 'Line updated successfully');
    }
}
