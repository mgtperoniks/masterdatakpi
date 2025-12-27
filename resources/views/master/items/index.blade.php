@extends('layouts.master')

@section('title', 'Master Items')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Items</h4>

    <div class="d-flex gap-2">
        {{-- IMPORT CSV --}}
        <a href="{{ route('master.items.import.form') }}"
           class="btn btn-outline-secondary">
            Import CSV
        </a>

        {{-- ADD ITEM --}}
        <a href="{{ route('master.items.create') }}"
           class="btn btn-primary">
            + Add Item
        </a>
    </div>
</div>

{{-- HARD STOP WARNING --}}
@if ($items->where('status', 'inactive')->count() > 0)
    <div class="alert alert-warning small">
        Ada item <strong>inactive</strong>. Item inactive tidak akan ditarik ke modul KPI.
    </div>
@endif

<div class="card">
    <div class="card-body p-0">

        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Cycle Time</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>

            @forelse ($items as $item)
                @php
                    $ctClass = $item->cycle_time_sec <= 60 ? 'text-success'
                             : ($item->cycle_time_sec <= 180 ? 'text-warning'
                             : 'text-danger');
                @endphp

                <tr class="{{ $item->status === 'inactive' ? 'opacity-50' : '' }}">
                    <td>
                        {{ $item->name }}
                    </td>

                    <td>
                        <span class="fw-bold {{ $ctClass }}">
                            {{ $item->cycle_time_sec }}
                        </span>
                        <small class="text-muted">sec</small>
                    </td>

                    <td>
                        @if ($item->status === 'inactive')
                            <span class="badge bg-secondary">Inactive</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>

                    <td class="text-end">
                        <a href="{{ route('master.items.edit', $item->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        No items available
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>

    </div>
</div>

@endsection
