@extends('layouts.master')

@section('title', 'Master Departments')
@section('page-title', 'Master Departments')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Master Department</h3>
    <a href="{{ route('master.departments.create') }}" class="btn btn-primary">
        + Add Department
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Status</th>
            <th width="120">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departments as $dept)
        <tr>
            <td>{{ $dept->code }}</td>
            <td>{{ $dept->name }}</td>
            <td>{{ ucfirst($dept->status) }}</td>
            <td>
                <a href="{{ route('master.departments.edit', $dept->id) }}" class="btn btn-sm btn-warning">
                    Edit
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
