<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdOperator;
use App\Models\MdDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperatorController extends Controller
{
    /**
     * Display a listing of operators.
     * Support: search, filter, pagination
     */
    public function index(Request $request)
    {
        $query = MdOperator::query();

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

        $operators = $query
            ->orderBy('code')
            ->paginate(20)        // ✅ pagination
            ->withQueryString(); // ✅ jaga query saat pindah halaman

        $departments = MdDepartment::orderBy('code')->get();

        return view(
            'master.operators.index',
            compact('operators', 'departments')
        );
    }

    /**
     * Show the form for creating a new operator.
     */
    public function create()
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.operators.create', compact('departments'));
    }

    /**
     * Store a newly created operator.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|string|max:50',
            'name'            => 'required|string|max:100',
            'department_code' => 'required|exists:md_departments,code',
        ]);

        DB::transaction(function () use ($request) {

            $activeExists = MdOperator::where('code', $request->code)
                ->where('status', 'active')
                ->exists();

            if ($activeExists) {
                abort(422, 'Kode operator masih aktif. Nonaktifkan terlebih dahulu.');
            }

            $lastSeq = MdOperator::where('code', $request->code)
                ->max('employment_seq');

            $nextSeq = $lastSeq ? $lastSeq + 1 : 1;

            MdOperator::create([
                'code'            => $request->code,
                'name'            => $request->name,
                'department_code' => $request->department_code,
                'employment_seq'  => $nextSeq,
                'status'          => 'active',
                'active_from'     => now()->toDateString(),
            ]);
        });

        return redirect()
            ->route('master.operators.index')
            ->with('success', 'Operator berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified operator.
     */
    public function edit(MdOperator $operator)
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view(
            'master.operators.edit',
            compact('operator', 'departments')
        );
    }

    /**
     * Update operator.
     */
    public function update(Request $request, MdOperator $operator)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:100',
            'department_code' => 'required|exists:md_departments,code',
            'status'          => 'required|in:active,inactive',
        ]);

        $operator->update($validated);

        return redirect()
            ->route('master.operators.index')
            ->with('success', 'Operator berhasil diperbarui.');
    }

    /**
     * Deactivate operator (no delete).
     */
    public function deactivate(int $id)
    {
        $operator = MdOperator::findOrFail($id);

        if ($operator->status === 'inactive') {
            return back();
        }

        $operator->update([
            'status'       => 'inactive',
            'active_until' => now()->toDateString(),
        ]);

        return back()->with('success', 'Operator berhasil dinonaktifkan.');
    }

    /**
     * Activate operator with new employment sequence.
     */
    public function activate(int $id)
    {
        DB::transaction(function () use ($id) {

            $old = MdOperator::findOrFail($id);

            if ($old->status === 'active') {
                return;
            }

            $activeExists = MdOperator::where('code', $old->code)
                ->where('status', 'active')
                ->exists();

            if ($activeExists) {
                abort(422, 'Masih ada operator aktif dengan kode ini.');
            }

            $nextSeq = MdOperator::where('code', $old->code)
                ->max('employment_seq') + 1;

            MdOperator::create([
                'code'            => $old->code,
                'name'            => $old->name,
                'department_code' => $old->department_code,
                'employment_seq'  => $nextSeq,
                'status'          => 'active',
                'active_from'     => now()->toDateString(),
            ]);
        });

        return back()->with('success', 'Operator berhasil diaktifkan kembali.');
    }
}
