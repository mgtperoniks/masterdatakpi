@extends('layouts.master')

@section('title', 'Edit Department')
@section('page-title', 'Edit Department')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('master.departments.update', $department->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text"
                       class="form-control"
                       value="{{ $department->code }}"
                       disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $department->name }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected($department->status === 'active')>
                        Active
                    </option>
                    <option value="inactive" @selected($department->status === 'inactive')>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">
                    Update
                </button>
                <a href="{{ route('master.departments.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
