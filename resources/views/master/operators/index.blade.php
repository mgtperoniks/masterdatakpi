@extends('layouts.master')

@section('title', 'Master Operators')
@section('page-title', 'Master Operators')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-2">
    <h4 class="mb-0">Master Operators</h4>

    <a href="{{ route('master.operators.create') }}"
       class="btn btn-primary">
        + Add Operator
    </a>
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
                    @selected(request('department_code') == $dept->code)>
                    {{ $dept->code }} – {{ $dept->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">-- All Status --</option>
            <option value="active" @selected(request('status') == 'active')>
                Active
            </option>
            <option value="inactive" @selected(request('status') == 'inactive')>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-primary">
            Filter
        </button>

        <a href="{{ route('master.operators.index') }}"
           class="btn btn-outline-secondary">
            Reset
        </a>
    </div>

</form>

{{-- ⚠️ WARNING --}}
@if ($operators->where('status', 'inactive')->count() > 0)
    <div class="alert alert-warning small">
        Terdapat <strong>operator inactive</strong>.
        Operator inactive tidak akan digunakan dalam modul KPI
        dan perhitungan performa.
    </div>
@endif

@if ($operators->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <h6 class="text-muted mb-2">No operators found</h6>
            <p class="text-muted small mb-3">
                Master Operator belum diisi.
            </p>
            <a href="{{ route('master.operators.create') }}"
               class="btn btn-primary">
                + Add Operator
            </a>
        </div>
    </div>
@else
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Seq</th>
                        <th>Active Period</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operators as $op)
                        <tr class="{{ $op->status === 'inactive' ? 'opacity-50' : '' }}">
                            <td>{{ $op->code }}</td>
                            <td>{{ $op->name }}</td>
                            <td>
                                {{ $op->department->code ?? '-' }}
                                –
                                {{ $op->department->name ?? '-' }}
                            </td>
                            <td>{{ $op->employment_seq }}</td>
                            <td class="small">
                                {{ $op->active_from ?? '-' }}
                                →
                                {{ $op->active_until ?? 'Present' }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $op->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($op->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">

                                    <a href="{{ route('master.operators.edit', $op->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>

                                    @if ($op->status === 'active')
                                        <button
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deactivateModal{{ $op->id }}">
                                            Deactivate
                                        </button>
                                    @else
                                        <form method="POST"
                                              action="{{ route('master.operators.activate', $op->id) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm btn-success"
                                                    onclick="return confirm('Aktifkan kembali operator ini?')">
                                                Activate
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>

                        {{-- 🔴 MODAL DEACTIVATE (WAJIB) --}}
                        <div class="modal fade"
                             id="deactivateModal{{ $op->id }}"
                             tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST"
                                      action="{{ route('master.operators.deactivate.confirm', $op) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Deactivate Operator
                                            </h5>
                                            <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p class="mb-3">
                                                <strong>
                                                    {{ $op->code }} – {{ $op->name }}
                                                </strong>
                                            </p>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Last Working Date
                                                </label>
                                                <input type="date"
                                                       name="inactive_at"
                                                       class="form-control"
                                                       required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Reason
                                                </label>
                                                <textarea name="inactive_reason"
                                                          class="form-control"
                                                          rows="3"
                                                          required></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button class="btn btn-danger">
                                                Confirm
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📄 PAGINATION --}}
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing
            {{ $operators->firstItem() }}
            –
            {{ $operators->lastItem() }}
            of
            {{ $operators->total() }}
            operators
        </div>

        <div>
            {{ $operators->links() }}
        </div>
    </div>
@endif

@endsection
