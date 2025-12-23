@extends('layouts.master')

@section('title', 'Master Machines')
@section('page-title', 'Master Machines')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Master Machine</h3>
    <a href="{{ route('master.machines.create') }}" class="btn btn-primary">
        + Add Machine
    </a>
</div>

<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Department</th>
            <th>Line</th>
            <th>Status DB</th>
            <th>Status Mesin</th>
            <th width="120">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($machines as $machine)
            <tr>
                <td>{{ $machine->code }}</td>
                <td>{{ $machine->name }}</td>
                <td>{{ $machine->department->name ?? '-' }}</td>
                <td>{{ $machine->line->name ?? '-' }}</td>

                {{-- Status dari database --}}
                <td>{{ ucfirst($machine->status) }}</td>

                {{-- Status runtime (computed, SSOT dari Model) --}}
                <td>
                    @if ($machine->computed_status === 'ONLINE')
                        <span class="fw-bold text-success">ONLINE</span>
                    @elseif ($machine->computed_status === 'STALE')
                        <span class="fw-bold text-warning">STALE</span>
                    @else
                        <span class="fw-bold text-danger">OFFLINE</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('master.machines.edit', $machine->id) }}"
                       class="btn btn-sm btn-warning">
                        Edit
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">
                    No machines found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
