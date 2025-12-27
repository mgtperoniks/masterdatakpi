@extends('layouts.master')

@section('title', 'Master Operators')
@section('page-title', 'Master Operators')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Operators</h4>

    <a href="{{ route('master.operators.create') }}"
       class="btn btn-primary">
        + Add Operator
    </a>
</div>

{{-- HARD STOP WARNING --}}
@if ($operators->where('status', 'inactive')->count() > 0)
    <div class="alert alert-warning small">
        Ada <strong>Operator inactive</strong>. Operator inactive tidak akan ditarik ke modul KPI
        dan tidak dihitung dalam perhitungan performa.
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
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operators as $operator)
                        <tr class="{{ $operator->status === 'inactive' ? 'opacity-50' : '' }}">
                            <td>{{ $operator->code }}</td>
                            <td>{{ $operator->name }}</td>
                            <td>{{ $operator->department->name ?? '-' }}</td>

                            <td>
                                <span class="badge bg-{{ $operator->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($operator->status) }}
                                </span>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('master.operators.edit', $operator->id) }}"
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
