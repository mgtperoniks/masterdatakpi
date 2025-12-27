@extends('layouts.master')

@section('title','Edit Item')
@section('page-title','Edit Item')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="{{ route('master.items.update', $item->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text" class="form-control" value="{{ $item->code }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $item->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_code" class="form-select" required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->code }}"
                            {{ $item->department_code == $dept->code ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Cycle Time (sec)</label>
                <input type="number" name="cycle_time_sec" class="form-control"
                       value="{{ $item->cycle_time_sec }}" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $item->status=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ $item->status=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('master.items.index') }}" class="btn btn-secondary ms-2">Cancel</a>

        </form>

    </div>
</div>

@endsection
