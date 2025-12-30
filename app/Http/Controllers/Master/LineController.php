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

    /**
     * Display a listing of lines.
     * Index tampil ACTIVE & INACTIVE
     */
    public function index()
    {
        $lines = MdLine::with('department')
            ->orderBy('code')
            ->get();

        return view('master.lines.index', compact('lines'));
    }

    /**
     * Show the form for creating a new line.
     * Dropdown department → hanya ACTIVE (hard guard)
     */
    public function create()
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.lines.create', compact('departments'));
    }

    /**
     * Store a newly created line.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'            => 'required|string|max:20|unique:md_lines,code',
            'department_code' => 'required|exists:md_departments,code',
            'name'            => 'required|string|max:100',
            'status'          => 'required|in:active,inactive',
        ]);

        $line = MdLine::create($validated);

        $this->audit(
            'md_lines',
            $line->code,
            'create',
            'master',
            'Create line'
        );

        return redirect()
            ->route('master.lines.index')
            ->with('success', 'Line berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified line.
     */
    public function edit(MdLine $line)
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.lines.edit', compact('line', 'departments'));
    }

    /**
     * Update the specified line.
     */
    public function update(Request $request, MdLine $line)
    {
        $validated = $request->validate([
            'department_code' => 'required|exists:md_departments,code',
            'name'            => 'required|string|max:100',
            'status'          => 'required|in:active,inactive',
        ]);

        $line->update($validated);

        $this->audit(
            'md_lines',
            $line->code,
            'update',
            'master',
            'Update line'
        );

        return redirect()
            ->route('master.lines.index')
            ->with('success', 'Line berhasil diperbarui.');
    }

    /**
     * Deactivate line (NO DELETE)
     */
    public function deactivate(MdLine $line)
    {
        $line->update([
            'status' => 'inactive',
        ]);

        $this->audit(
            'md_lines',
            $line->code,
            'deactivate',
            'master',
            'Deactivate line'
        );

        return back()->with('success', 'Line dinonaktifkan.');
    }

    /**
     * Activate line
     */
    public function activate(MdLine $line)
    {
        $line->update([
            'status' => 'active',
        ]);

        $this->audit(
            'md_lines',
            $line->code,
            'activate',
            'master',
            'Activate line'
        );

        return back()->with('success', 'Line diaktifkan kembali.');
    }
}
