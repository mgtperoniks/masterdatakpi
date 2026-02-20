<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MdItem;
use App\Models\MdDepartment;

class ItemController extends Controller
{
    /**
     * Display a listing of the items.
     * Index tampil ACTIVE & INACTIVE
     * Support: search, filter, pagination
     */
    public function index(Request $request)
    {
        $query = MdItem::query();

        // 🔍 Search (code / name)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            });
        }

        // 🔒 Scoping: REMOVED as per request. All admins can see all departments.
        /*
        $user = auth()->user();
        if (!in_array($user->role, ['manager', 'direktur', 'mr'])) {
            $query->where('department_code', $user->department_code);
        } elseif ($request->filled('department_code')) {
            // Global roles can filter manually
            $query->where('department_code', $request->department_code);
        }
        */

        // Global roles and regular admins can filter manually
        if ($request->filled('department_code')) {
            $query->where('department_code', $request->department_code);
        }

        // 🔄 Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query
            ->orderBy('code')
            ->paginate(20)       // ✅ WAJIB: pagination
            ->withQueryString(); // ✅ jaga query saat pindah halaman

        $departments = MdDepartment::orderBy('code')->get();

        return view('master.items.index', compact('items', 'departments'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.items.create', compact('departments'));
    }

    /**
     * Store a newly created item.
     */
    public function store(Request $request)
    {
        if (auth()->user()->isReadOnly()) {
            return back()->with('error', 'Mode Read-Only: Tidak diizinkan menambah data.');
        }
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:md_items,code',
            'name' => 'required|string|max:150',
            'aisi' => 'nullable|string|max:50',
            'standard' => 'nullable|string|max:20',
            'unit_weight' => 'nullable|numeric|min:0',
            'department_code' => 'required|exists:md_departments,code',
            'cycle_time_sec' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        MdItem::create($validated);

        return redirect()
            ->route('master.items.index')
            ->with('success', 'Item berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(MdItem $item)
    {
        $departments = MdDepartment::where('status', 'active')
            ->orderBy('code')
            ->get();

        return view('master.items.edit', compact('item', 'departments'));
    }

    /**
     * Update the specified item.
     */
    public function update(Request $request, MdItem $item)
    {
        if (auth()->user()->isReadOnly()) {
            return back()->with('error', 'Mode Read-Only: Tidak diizinkan mengubah data.');
        }
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:md_items,code,' . $item->id,
            'name' => 'required|string|max:150',
            'aisi' => 'nullable|string|max:50',
            'standard' => 'nullable|string|max:20',
            'unit_weight' => 'nullable|numeric|min:0',
            'department_code' => 'required|exists:md_departments,code',
            'cycle_time_sec' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $item->update($validated);

        return redirect()
            ->route('master.items.index')
            ->with('success', 'Item berhasil diperbarui.');
    }

    /**
     * Deactivate item (NO DELETE)
     */
    public function deactivate(MdItem $item)
    {
        if (auth()->user()->isReadOnly()) {
            return back()->with('error', 'Mode Read-Only: Tidak diizinkan menonaktifkan data.');
        }
        $item->update([
            'status' => 'inactive',
        ]);

        return back()->with('success', 'Item dinonaktifkan.');
    }

    /**
     * Activate item
     */
    public function activate(MdItem $item)
    {
        if (auth()->user()->isReadOnly()) {
            return back()->with('error', 'Mode Read-Only: Tidak diizinkan mengaktifkan data.');
        }
        $item->update([
            'status' => 'active',
        ]);

        return back()->with('success', 'Item diaktifkan kembali.');
    }
}
