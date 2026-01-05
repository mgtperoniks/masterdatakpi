@extends('layouts.master')

@section('title', 'Master Items')

@php
    use App\Helpers\Permission;
@endphp

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Items</h4>

    @if (Permission::canManage('items'))
        <div class="d-flex gap-2">
            <a href="{{ route('master.items.import.form') }}"
               class="btn btn-outline-secondary">
                Import CSV
            </a>

            <a href="{{ route('master.items.create') }}"
               class="btn btn-primary">
                + Add Item
            </a>
        </div>
    @endif
</div>

{{-- 🔍 SEARCH & FILTER --}}
<form method="GET" class="row g-2 mb-3">

    <div class="col-md-4">
        <input type="text"
               name="q"
               value="{{ request('q') }}"
               class="form-control"
               placeholder="Search code or name...">
    </div>

    <div class="col-md-3">
        <select name="department_code" class="form-select">
            <option value="">-- All Departments --</option>
            @foreach ($departments as $dept)
                <option value="{{ $dept->code }}"
                    {{ request('department_code') == $dept->code ? 'selected' : '' }}>
                    {{ $dept->code }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">-- All Status --</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                Active
            </option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-primary">
            Filter
        </button>

        <a href="{{ route('master.items.index') }}"
           class="btn btn-outline-secondary">
            Reset
        </a>
    </div>

</form>

{{-- ⚠️ WARNING: INACTIVE ITEMS --}}
@if ($items->where('status', 'inactive')->count() > 0)
    <div class="alert alert-warning small">
        Ada item <strong>inactive</strong>. Item inactive tidak akan ditarik ke modul KPI.
    </div>
@endif

<div class="card">
    <div class="card-body p-0">

        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>AISI</th>
                    <th>Standard</th>
                    <th>Weight (kg)</th>
                    <th>Cycle Time</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>

            @forelse ($items as $item)
                @php
                    $ctClass = $item->cycle_time_sec <= 60
                        ? 'text-success'
                        : ($item->cycle_time_sec <= 180
                            ? 'text-warning'
                            : 'text-danger');
                @endphp

                <tr class="{{ $item->status === 'inactive' ? 'opacity-50' : '' }}">

                    <td>{{ $item->name }}</td>
                    <td>{{ $item->aisi ?? '-' }}</td>
                    <td>{{ $item->standard ?? '-' }}</td>

                    <td>
                        {{ $item->unit_weight !== null
                            ? number_format($item->unit_weight, 3)
                            : '-' }}
                    </td>

                    <td>
                        <span class="fw-bold {{ $ctClass }}">
                            {{ $item->cycle_time_sec }}
                        </span>
                        <small class="text-muted">sec</small>
                    </td>

                    <td>
                        <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>

                    <td class="text-end">
                        @if (Permission::canManage('items'))

                            <a href="{{ route('master.items.edit', $item) }}"
                               class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>

                            @if ($item->status === 'active')
                                <form method="POST"
                                      action="{{ route('master.items.deactivate', $item) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-warning">
                                        Deactivate
                                    </button>
                                </form>
                            @else
                                <form method="POST"
                                      action="{{ route('master.items.activate', $item) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">
                                        Activate
                                    </button>
                                </form>
                            @endif

                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No items available
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>

    </div>
</div>

{{-- 📄 PAGINATION --}}
<div class="mt-3 d-flex justify-content-between align-items-center">
    <div class="text-muted small">
        Showing
        {{ $items->firstItem() }}
        –
        {{ $items->lastItem() }}
        of
        {{ $items->total() }}
        items
    </div>

    <div>
        {{ $items->links() }}
    </div>
</div>

{{-- ✅ FIX: Pagination arrow terlalu besar --}}
<style>
    .pagination .page-link {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        line-height: 1.25;
    }

    .pagination svg {
        width: 16px !important;
        height: 16px !important;
    }
</style>

@endsection
