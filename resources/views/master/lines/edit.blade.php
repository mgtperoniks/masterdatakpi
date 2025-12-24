@extends('layouts.master')

@section('title', 'Edit Line')
@section('page-title', 'Edit Line')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('master.lines.update', $line->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text"
                       class="form-control"
                       value="{{ $line->code }}"
                       disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_code"
                        class="form-select"
                        required>
                    @foreach($departments as $department)
                        <option value="{{ $department->code }}"
                            @selected($department->code === $line->department_code)>
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
                       value="{{ $line->name }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected($line->status === 'active')>
                        Active
                    </option>
                    <option value="inactive" @selected($line->status === 'inactive')>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">
                    Update
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
