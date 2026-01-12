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
                    <option value="{{ $tbl }}" {{ request('table_name') === $tbl ? 'selected' : '' }}>
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
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
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
                        <th>User</th>
                        <th>Table</th>
                        <th>Record</th>
                        <th>Action</th>
                        <th>Source</th>
                        <th>IP Address</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>

                @forelse ($logs as $log)
                    <tr>
                        <td class="text-muted small">
                            {{ $log->created_at->format('Y-m-d H:i') }}
                        </td>

                        <td>
                            @if($log->user)
                                <div class="fw-bold">{{ $log->user->name }}</div>
                                <div class="text-[10px] text-slate-500 italic">{{ $log->user->email }}</div>
                            @else
                                <span class="text-slate-400 italic">System</span>
                            @endif
                        </td>

                        <td class="small">
                            {{ $log->table_name }}
                        </td>

                        <td class="fw-bold small">
                            {{ $log->record_code }}
                        </td>

                        <td>
                            @php
                                $actionClass = match($log->action) {
                                    'create' => 'emerald',
                                    'update' => 'amber',
                                    'deactivate', 'delete' => 'rose',
                                    'sync' => 'blue',
                                    default => 'slate'
                                };
                            @endphp

                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-{{ $actionClass }}-50 text-{{ $actionClass }}-700 border border-{{ $actionClass }}-200">
                                {{ strtoupper($log->action) }}
                            </span>
                        </td>

                        <td class="small">
                            {{ strtoupper($log->source) }}
                        </td>

                        <td class="small font-mono text-slate-500">
                            {{ $log->ip_address ?? '-' }}
                        </td>

                        <td class="small text-muted">
                            <div>{{ $log->description }}</div>
                            @if($log->old_values || $log->new_values)
                                <button type="button" class="text-[10px] text-primary hover:underline mt-1" 
                                        onclick="this.nextElementSibling.classList.toggle('hidden')">
                                    Show Changes
                                </button>
                                <div class="hidden mt-2 p-2 bg-slate-50 rounded text-[9px] font-mono overflow-x-auto max-w-xs">
                                    @if($log->old_values)
                                        <div class="text-rose-600">OLD: {{ json_encode($log->old_values) }}</div>
                                    @endif
                                    @if($log->new_values)
                                        <div class="text-emerald-600">NEW: {{ json_encode($log->new_values) }}</div>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            No audit logs found.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection