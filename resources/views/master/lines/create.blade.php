@extends('layouts.master')

@section('title', 'Create Line')
@section('page-title', 'Create Line')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('master.lines.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text"
                       name="code"
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
                <label class="form-label">Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">
                    Save
                </button>
                <a href="{{ route('master.lines.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
