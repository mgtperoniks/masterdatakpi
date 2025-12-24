@extends('layouts.master')

@section('title', 'Master Departments')
@section('page-title', 'Master Departments')

@section('content')

{{-- Header Halaman --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Departments</h4>

    <a href="{{ route('master.departments.create') }}" class="btn btn-primary">
        + Add Department
    </a>
</div>

{{-- Empty State --}}
@if($departments->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <h6 class="text-muted mb-2">No departments found</h6>
            <p class="text-muted small mb-3">
                Master Department belum diisi.
            </p>
            <a href="{{ route('master.departments.create') }}" class="btn btn-primary">
                + Add Department
            </a>
        </div>
    </div>
@else

{{-- Table --}}
<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td>{{ $department->code }}</td>
                        <td>{{ $department->name }}</td>
                        <td>
                            @php
                                $statusClass = match($department->status) {
                                    'active' => 'success',
                                    'inactive' => 'secondary',
                                    'maintenance' => 'warning',
                                    default => 'light',
                                };
                            @endphp

                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst($department->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('master.departments.edit', $department->id) }}"
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
