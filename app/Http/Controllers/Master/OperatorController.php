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
     */
    public function index(Request $request)
    {
        $query = MdOperator::query();

        // Search code / name
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            });
        }

        // 🔒 Scoping: Admin Dept only sees their own department
        $user = auth()->user();
        if (!in_array($user->role, ['manager', 'direktur', 'mr'])) {
            $query->where('department_code', $user->department_code);
        } elseif ($request->filled('department_code')) {
            // Global roles can filter manually
            $query->where('department_code', $request->department_code);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $operators = $query
            ->orderBy('code')
            ->orderByDesc('employment_seq')
            ->paginate(20)
            ->withQueryString();

        $departments = MdDepartment::orderBy('code')->get();

        return view('master.operators.index', compact(
            'operators',
            'departments'
        ));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.operators.create', compact('departments'));
    }

    /**
     * Store new operator.
     */
    public function store(Request $request)
    {
        if (auth()->user()->isReadOnly()) {
            return back()->with('error', 'Mode Read-Only: Tidak diizinkan menambah data.');
        }
        $validated = $request->validate([
            'code' => 'required|string|max:30',
            'name' => 'required|string|max:150',
            'department_code' => 'required|exists:md_departments,code',
            'position' => 'required|string|max:100',
            'gender' => 'nullable|in:male,female',
            'employment_type' => 'required|in:PKWT,PKWTT,OUTSOURCE',
            'join_date' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {

            $activeExists = MdOperator::where('code', $validated['code'])
                ->where('status', 'active')
                ->exists();

            if ($activeExists) {
                abort(422, 'Kode operator masih aktif. Nonaktifkan terlebih dahulu.');
            }

            $lastSeq = MdOperator::where('code', $validated['code'])
                ->max('employment_seq');

            $nextSeq = $lastSeq ? $lastSeq + 1 : 1;

            MdOperator::create([
                ...$validated,
                'employment_seq' => $nextSeq,
                'status' => 'active',
                'active_from' => $validated['join_date'],
            ]);
        });

        return redirect()
            ->route('master.operators.index')
            ->with('success', 'Operator berhasil ditambahkan.');
    }

    /**
     * Show edit form.
     */
    public function edit(MdOperator $operator)
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.operators.edit', compact(
            'operator',
            'departments'
        ));
    }

    /**
     * Update operator.
     */
    public function update(Request $request, MdOperator $operator)
    {
        if (auth()->user()->isReadOnly()) {
            return back()->with('error', 'Mode Read-Only: Tidak diizinkan mengubah data.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'department_code' => 'required|exists:md_departments,code',
            'position' => 'required|string|max:100',
            'gender' => 'nullable|in:male,female',
            'employment_type' => 'required|in:PKWT,PKWTT,OUTSOURCE',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $operator->update($validated);

        return redirect()
            ->route('master.operators.index')
            ->with('success', 'Operator berhasil diperbarui.');
    }

    /**
     * Confirm deactivate operator (with reason & date).
     */
    public function confirmDeactivate(Request $request, MdOperator $operator)
    {
        if (auth()->user()->isReadOnly()) {
            return back()->with('error', 'Mode Read-Only: Tidak diizinkan menonaktifkan data.');
        }
        $request->validate([
            'inactive_at' => 'required|date',
            'inactive_reason' => 'required|string|min:5',
        ]);

        if ($operator->status === 'inactive') {
            return back();
        }

        $operator->update([
            'status' => 'inactive',
            'inactive_at' => $request->inactive_at,
            'inactive_reason' => $request->inactive_reason,
            'active_until' => $request->inactive_at,
        ]);

        return redirect()
            ->route('master.operators.index')
            ->with('success', 'Operator berhasil dinonaktifkan.');
    }

    /**
     * Reactivate operator with new employment sequence.
     */
    public function activate(int $id)
    {
        if (auth()->user()->isReadOnly()) {
            return back()->with('error', 'Mode Read-Only: Tidak diizinkan mengaktifkan data.');
        }
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
                'code' => $old->code,
                'name' => $old->name,
                'department_code' => $old->department_code,
                'position' => $old->position,
                'gender' => $old->gender,
                'employment_type' => $old->employment_type,
                'join_date' => $old->join_date,
                'employment_seq' => $nextSeq,
                'status' => 'active',
                'active_from' => now()->toDateString(),
            ]);
        });

        return back()->with('success', 'Operator berhasil diaktifkan kembali.');
    }
}
