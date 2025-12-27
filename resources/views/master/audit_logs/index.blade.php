@extends('layouts.master')

@section('title', 'Audit Log')

@section('content')
    <h4 class="mb-3">Audit Log</h4>

    {{-- FILTER BAR --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="table_name" class="form-select">
                <option value="">All Tables</option>
                @foreach ($tables as $tbl)
                    <option value="{{ $tbl }}"
                        {{ request('table_name') === $tbl ? 'selected' : '' }}>
                        {{ $tbl }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="action" class="form-select">
                <option value="">All Actions</option>
                <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>
                    Create
                </option>
                <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>
                    Update
                </option>
                <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>
                    Delete
                </option>
                <option value="sync" {{ request('action') === 'sync' ? 'selected' : '' }}>
                    Sync
                </option>
            </select>
        </div>

        <div class="col-md-2">
            <input type="date"
                   name="date"
                   class="form-control"
                   value="{{ request('date') }}">
        </div>

        <div class="col-md-2">
            <button class="btn btn-outline-primary w-100">
                Filter
            </button>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Time</th>
                        <th>Table</th>
                        <th>Record</th>
                        <th>Action</th>
                        <th>Source</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>

                @forelse ($logs as $log)
                    <tr>
                        <td class="text-muted small">
                            {{ $log->created_at }}
                        </td>

                        <td>
                            {{ $log->table_name }}
                        </td>

                        <td class="fw-bold">
                            {{ $log->record_code }}
                        </td>

                        <td>
                            @php
                                $actionClass = $log->action === 'create' ? 'success'
                                            : ($log->action === 'update' ? 'warning'
                                            : ($log->action === 'delete' ? 'danger'
                                            : 'secondary'));
                            @endphp

                            <span class="badge bg-{{ $actionClass }}">
                                {{ strtoupper($log->action) }}
                            </span>
                        </td>

                        <td>
                            {{ $log->source }}
                        </td>

                        <td class="small text-muted">
                            {{ $log->description }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No audit logs found.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
