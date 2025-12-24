@extends('layouts.master')

@section('title', 'Create Machine')
@section('page-title', 'Create Machine')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('master.machines.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text"
                       name="code"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_code"
                        class="form-select"
                        required>
                    @foreach($departments as $department)
                        <option value="{{ $department->code }}">
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
                        <option value="{{ $line->code }}">
                            {{ $line->code }} - {{ $line->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">
                    Save
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
