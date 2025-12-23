@extends('layouts.app')

@section('content')
<h3>Edit Line</h3>

<form method="POST" action="{{ route('master.lines.update', $line->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Code</label>
        <input type="text" class="form-control" value="{{ $line->code }}" disabled>
    </div>

    <div class="mb-3">
        <label class="form-label">Department</label>
        <select name="department_code" class="form-select" required>
            @foreach($departments as $dept)
                <option value="{{ $dept->code }}"
                    @selected($dept->code === $line->department_code)>
                    {{ $dept->code }} - {{ $dept->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control"
               value="{{ $line->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" @selected($line->status=='active')>Active</option>
            <option value="inactive" @selected($line->status=='inactive')>Inactive</option>
        </select>
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('master.lines.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
