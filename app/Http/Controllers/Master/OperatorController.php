<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MdOperator;
use App\Models\MdDepartment;

class OperatorController extends Controller
{
    /**
     * Display a listing of operators.
     */
    public function index()
    {
        $operators = MdOperator::with('department')
            ->orderBy('code')
            ->get();

        return view('master.operators.index', compact('operators'));
    }

    /**
     * Show the form for creating a new operator.
     */
    public function create()
    {
        $departments = MdDepartment::orderBy('code')->get();

        return view('master.operators.create', compact('departments'));
    }

    /**
     * Store a newly created operator.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'            => 'required|string|max:30|unique:md_operators,code',
            'name'            => 'required|string|max:100',
            'department_code' => 'required|exists:md_departments,code',
            'status'          => 'required|in:active,inactive',
        ]);

        MdOperator::create($validated);

        return redirect()
            ->route('master.operators.index')
            ->with('success', 'Operator berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified operator.
     */
    public function edit(MdOperator $operator)
    {
        $departments = MdDepartment::orderBy('code')->get();

        return view('master.operators.edit', compact('operator', 'departments'));
    }

    /**
     * Update the specified operator.
     */
    public function update(Request $request, MdOperator $operator)
    {
        $validated = $request->validate([
            'code'            => 'required|string|max:30|unique:md_operators,code,' . $operator->id,
            'name'            => 'required|string|max:100',
            'department_code' => 'required|exists:md_departments,code',
            'status'          => 'required|in:active,inactive',
        ]);

        $operator->update($validated);

        return redirect()
            ->route('master.operators.index')
            ->with('success', 'Operator berhasil diperbarui.');
    }
}
