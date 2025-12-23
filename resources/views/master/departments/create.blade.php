@extends('layouts.app')

@section('content')
<h3>Create Department</h3>

<form method="POST" action="{{ route('master.departments.store') }}">
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
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('master.departments.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
