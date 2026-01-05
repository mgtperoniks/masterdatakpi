@extends('layouts.master')

@section('title', 'Master Departments')
@section('page-title', 'Master Departments')

@section('content')

{{-- Header Halaman --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Departments</h4>

    <a href="{{ route('master.departments.create') }}"
       class="btn btn-primary">
        + Add Department
    </a>
</div>

{{-- 🔍 SEARCH & FILTER --}}
<form method="GET" class="row g-2 mb-3">

    <div class="col-md-4">
        <input type="text"
               name="q"
               value="{{ request('q') }}"
               class="form-control"
               placeholder="Search code / name">
    </div>

    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- All Status --</option>
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

{{-- Empty State --}}
@if ($departments->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <h6 class="text-muted mb-2">No departments found</h6>
            <p class="text-muted small mb-3">
                Master Department belum diisi.
            </p>
            <a href="{{ route('master.departments.create') }}"
               class="btn btn-primary">
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
                            <span class="badge {{ $department->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($department->status) }}
                            </span>
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

{{-- 📄 PAGINATION --}}
<div class="mt-3">
    {{ $departments->links() }}
</div>

@endif

@endsection
