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
     */
    public function index(Request $request)
    {
        $query = MdItem::query();

        if ($request->filled('department_code')) {
            $query->where('department_code', $request->department_code);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query
            ->orderBy('code')
            ->get();

        $departments = MdDepartment::orderBy('code')->get();

        return view('master.items.index', compact('items', 'departments'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        $departments = MdDepartment::orderBy('code')->get();

        return view('master.items.create', compact('departments'));
    }

    /**
     * Store a newly created item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'            => 'required|string|max:50|unique:md_items,code',
            'name'            => 'required|string|max:150',
            'department_code' => 'required|exists:md_departments,code',
            'cycle_time_sec'  => 'required|integer|min:1',
            'status'          => 'required|in:active,inactive',
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
        $departments = MdDepartment::orderBy('code')->get();

        return view('master.items.edit', compact('item', 'departments'));
    }

    /**
     * Update the specified item.
     */
    public function update(Request $request, MdItem $item)
    {
        $validated = $request->validate([
            'code'            => 'required|string|max:50|unique:md_items,code,' . $item->id,
            'name'            => 'required|string|max:150',
            'department_code' => 'required|exists:md_departments,code',
            'cycle_time_sec'  => 'required|integer|min:1',
            'status'          => 'required|in:active,inactive',
        ]);

        $item->update($validated);

        return redirect()
            ->route('master.items.index')
            ->with('success', 'Item berhasil diperbarui.');
    }
}
