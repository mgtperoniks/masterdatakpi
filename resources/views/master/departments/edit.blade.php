@extends('layouts.app')

@section('content')
<h3>Edit Department</h3>

<form method="POST" action="{{ route('master.departments.update', $department->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Code</label>
        <input type="text" class="form-control" value="{{ $department->code }}" disabled>
    </div>

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $department->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" @selected($department->status=='active')>Active</option>
            <option value="inactive" @selected($department->status=='inactive')>Inactive</option>
        </select>
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('master.departments.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
