@extends('layouts.master')

@section('title','Import Items')
@section('page-title','Import Items (CSV)')

@php
    use App\Helpers\Permission;
@endphp

@section('content')

{{-- HARD GUARD (WAJIB UNTUK AKSI MASSAL) --}}
@if (!Permission::canManage('items'))

    <div class="alert alert-danger">
        Anda tidak diizinkan melakukan import data.
    </div>

@else

<div class="card shadow-sm">
    <div class="card-body">

        <div class="alert alert-info small">
            Gunakan template CSV dengan format:<br>
            <code>code,name,department_code,cycle_time_sec,status</code>
        </div>

        <form method="POST"
              enctype="multipart/form-data"
              action="{{ route('master.items.import') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">CSV File</label>
                <input type="file"
                       name="file"
                       class="form-control"
                       required>
            </div>

            <button class="btn btn-primary">
                Import Items
            </button>

            <a href="{{ route('master.items.index') }}"
               class="btn btn-secondary ms-2">
                Back
            </a>
        </form>

    </div>
</div>

{{-- IMPORT ERRORS (TETAP AMAN, READ ONLY) --}}
@if (session('import_errors'))
    <div class="alert alert-warning mt-3 small">
        <strong>Beberapa baris gagal:</strong>
        <ul class="mb-0">
            @foreach (session('import_errors') as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endif

@endsection
