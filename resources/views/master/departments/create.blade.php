@extends('layouts.master')

@section('title', 'Create Department')
@section('page-title', 'Create Department')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('master.departments.store') }}">
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
                <a href="{{ route('master.departments.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
