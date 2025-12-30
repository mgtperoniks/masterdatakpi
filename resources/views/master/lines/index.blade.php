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

@if ($lines->isEmpty())
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
            <table class="table table-hover align-middle mb-0">
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
                    @foreach ($lines as $line)
                        <tr class="{{ $line->status === 'inactive' ? 'opacity-50' : '' }}">
                            <td>{{ $line->code }}</td>
                            <td>{{ $line->department->name ?? '-' }}</td>
                            <td>{{ $line->name }}</td>
                            <td>
                                @if ($line->status === 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td class="text-end">

                                {{-- EDIT --}}
                                <a href="{{ route('master.lines.edit', $line) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                {{-- ACTIVATE / DEACTIVATE --}}
                                @if ($line->status === 'active')
                                    <form method="POST"
                                          action="{{ route('master.lines.deactivate', $line) }}"
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-warning">
                                            Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                          action="{{ route('master.lines.activate', $line) }}"
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
