@extends('layouts.master')

@section('title','Add Item')
@section('page-title','Add Item')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="{{ route('master.items.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text" name="code" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_code" class="form-select" required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->code }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Cycle Time (sec)</label>
                <input type="number" name="cycle_time_sec" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button class="btn btn-primary">Save</button>
            <a href="{{ route('master.items.index') }}" class="btn btn-secondary ms-2">Cancel</a>

        </form>

    </div>
</div>

@endsection
