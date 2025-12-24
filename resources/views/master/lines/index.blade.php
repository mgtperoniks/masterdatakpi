@extends('layouts.master')

@section('title', 'Master Lines')
@section('page-title', 'Master Lines')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Lines</h4>

    <a href="{{ route('master.lines.create') }}" class="btn btn-primary">
        + Add Line
    </a>
</div>

@if($lines->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <h6 class="text-muted mb-2">No lines found</h6>
            <p class="text-muted small mb-3">
                Master Line belum diisi.
            </p>
            <a href="{{ route('master.lines.create') }}" class="btn btn-primary">
                + Add Line
            </a>
        </div>
    </div>
@else
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lines as $line)
                        <tr>
                            <td>{{ $line->code }}</td>
                            <td>{{ $line->department->name ?? '-' }}</td>
                            <td>{{ $line->name }}</td>
                            <td>
                                @php
                                    $statusClass = match($line->status) {
                                        'active' => 'success',
                                        'inactive' => 'secondary',
                                        'maintenance' => 'warning',
                                        default => 'light',
                                    };
                                @endphp

                                <span class="badge bg-{{ $statusClass }}">
                                    {{ ucfirst($line->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('master.lines.edit', $line->id) }}"
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
