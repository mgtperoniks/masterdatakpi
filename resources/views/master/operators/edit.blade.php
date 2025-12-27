@extends('layouts.master')

@section('title','Edit Operator')
@section('page-title','Edit Operator')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST"
              action="{{ route('master.operators.update', $operator->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text" class="form-control"
                       value="{{ $operator->code }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $operator->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_code" class="form-select" required>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->code }}"
                            {{ $operator->department_code === $dept->code ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $operator->status=='active'?'selected':'' }}>
                        Active
                    </option>
                    <option value="inactive" {{ $operator->status=='inactive'?'selected':'' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('master.operators.index') }}"
               class="btn btn-secondary ms-2">Cancel</a>

        </form>

    </div>
</div>

@endsection
