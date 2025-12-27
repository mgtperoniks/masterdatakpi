@extends('layouts.master')

@section('title', 'Master Machines')
@section('page-title', 'Master Machines')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Machines</h4>

    <a href="{{ route('master.machines.create') }}" class="btn btn-primary">
        + Add Machine
    </a>
</div>

{{-- HARD STOP WARNING --}}
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
            <a href="{{ route('master.machines.create') }}" class="btn btn-primary">
                + Add Machine
            </a>
        </div>
    </div>
@else
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
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

                            <td>
                                @php
                                    $statusClass = match ($machine->status) {
                                        'active' => 'success',
                                        'inactive' => 'secondary',
                                        'maintenance' => 'warning',
                                        default => 'light',
                                    };
                                @endphp

                                <span class="badge bg-{{ $statusClass }}">
                                    {{ ucfirst($machine->status) }}
                                </span>
                            </td>

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
                                <a href="{{ route('master.machines.edit', $machine->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
