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
@if ($departments->isEmpty())
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

        <table class="table table-hover align-middle mb-0">
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
                    <tr class="{{ $department->status === 'inactive' ? 'opacity-50' : '' }}">
                        <td>{{ $department->code }}</td>
                        <td>{{ $department->name }}</td>
                        <td>
                            @if ($department->status === 'inactive')
                                <span class="badge bg-secondary">Inactive</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </td>
                        <td class="text-end">

                            {{-- EDIT --}}
                            <a href="{{ route('master.departments.edit', $department) }}"
                               class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>

                            {{-- ACTIVATE / DEACTIVATE --}}
                            @if ($department->status === 'active')
                                <form method="POST"
                                      action="{{ route('master.departments.deactivate', $department) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-warning">
                                        Deactivate
                                    </button>
                                </form>
                            @else
                                <form method="POST"
                                      action="{{ route('master.departments.activate', $department) }}"
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
@endif

@endsection
