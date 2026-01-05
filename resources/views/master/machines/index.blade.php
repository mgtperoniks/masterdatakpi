@extends('layouts.master')

@section('title', 'Master Machines')
@section('page-title', 'Master Machines')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Machines</h4>

    <a href="{{ route('master.machines.create') }}"
       class="btn btn-primary">
        + Add Machine
    </a>
</div>

{{-- 🔍 FILTER BAR --}}
<form method="GET" class="row g-2 mb-3">

    <div class="col-md-4">
        <input type="text"
               name="q"
               value="{{ request('q') }}"
               class="form-control"
               placeholder="Search code / name">
    </div>

    <div class="col-md-3">
        <select name="department_code" class="form-select">
            <option value="">-- All Departments --</option>
            @foreach ($departments as $dept)
                <option value="{{ $dept->code }}"
                    {{ request('department_code') === $dept->code ? 'selected' : '' }}>
                    {{ $dept->code }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                Active
            </option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            Filter
        </button>
    </div>

</form>

{{-- ⚠️ HARD STOP WARNING --}}
@if ($machines->where('status', 'inactive')->count() > 0)
    <div class="alert alert-warning small">
        Ada <strong>Machine inactive</strong>. Machine inactive tidak akan ditarik ke modul KPI
        dan tidak dihitung dalam monitoring runtime.
    </div>
@endif

@if ($machines->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <h6 class="text-muted mb-2">No machines found</h6>
            <p class="text-muted small mb-3">
                Master Machine belum diisi.
            </p>
            <a href="{{ route('master.machines.create') }}"
               class="btn btn-primary">
                + Add Machine
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
                        <th>Line</th>
                        <th>Status DB</th>
                        <th>Status Mesin</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($machines as $machine)
                        <tr class="{{ $machine->status === 'inactive' ? 'opacity-50' : '' }}">
                            <td>{{ $machine->code }}</td>
                            <td>{{ $machine->name }}</td>
                            <td>{{ $machine->department->name ?? '-' }}</td>
                            <td>{{ $machine->line->name ?? '-' }}</td>

                            {{-- STATUS DB --}}
                            <td>
                                <span class="badge {{ $machine->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($machine->status) }}
                                </span>
                            </td>

                            {{-- STATUS MESIN (RUNTIME / COMPUTED) --}}
                            <td>
                                @php
                                    $runtimeClass = match ($machine->computed_status) {
                                        'ONLINE' => 'success',
                                        'STALE'  => 'warning',
                                        default  => 'danger',
                                    };
                                @endphp

                                <span class="badge bg-{{ $runtimeClass }}">
                                    {{ $machine->computed_status }}
                                </span>
                            </td>

                            <td class="text-end">

                                {{-- EDIT --}}
                                <a href="{{ route('master.machines.edit', $machine) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                {{-- ACTIVATE / DEACTIVATE --}}
                                @if ($machine->status === 'active')
                                    <form method="POST"
                                          action="{{ route('master.machines.deactivate', $machine) }}"
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-warning">
                                            Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                          action="{{ route('master.machines.activate', $machine) }}"
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success">
                                            Activate
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📄 PAGINATION --}}
    <div class="mt-3">
        {{ $machines->links() }}
    </div>
@endif

@endsection
