@extends('layouts.master')

@section('title', 'Edit Machine')
@section('page-title', 'Edit Machine')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('master.machines.update', $machine->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text"
                       class="form-control"
                       value="{{ $machine->code }}"
                       disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $machine->name }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_code"
                        class="form-select"
                        required>
                    @foreach($departments as $department)
                        <option value="{{ $department->code }}"
                            @selected($department->code === $machine->department_code)>
                            {{ $department->code }} - {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Line (Optional)</label>
                <select name="line_code" class="form-select">
                    <option value="">-- None --</option>
                    @foreach($lines as $line)
                        <option value="{{ $line->code }}"
                            @selected($line->code === $machine->line_code)>
                            {{ $line->code }} - {{ $line->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected($machine->status === 'active')>
                        Active
                    </option>
                    <option value="maintenance" @selected($machine->status === 'maintenance')>
                        Maintenance
                    </option>
                    <option value="inactive" @selected($machine->status === 'inactive')>
                        Inactive
                    </option>
                </select>
            </div>

            {{-- Read-only Sync Info --}}
            <div class="mb-3">
                <label class="form-label">Last Active Module</label>
                <input type="text"
                       class="form-control"
                       value="{{ $machine->last_active_module }}"
                       disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Last Seen At</label>
                <input type="text"
                       class="form-control"
                       value="{{ $machine->last_seen_at }}"
                       disabled>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">
                    Update
                </button>
                <a href="{{ route('master.machines.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
