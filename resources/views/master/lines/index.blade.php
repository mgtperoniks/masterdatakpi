@extends('layouts.master')

@section('title', 'Master Lines')
@section('page-title', 'Master Lines')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Master Line</h3>
    <a href="{{ route('master.lines.create') }}" class="btn btn-primary">
        + Add Line
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Code</th>
            <th>Department</th>
            <th>Name</th>
            <th>Status</th>
            <th width="120">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lines as $line)
        <tr>
            <td>{{ $line->code }}</td>
            <td>{{ $line->department->name ?? '-' }}</td>
            <td>{{ $line->name }}</td>
            <td>{{ ucfirst($line->status) }}</td>
            <td>
                <a href="{{ route('master.lines.edit', $line->id) }}"
                   class="btn btn-sm btn-warning">
                    Edit
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
