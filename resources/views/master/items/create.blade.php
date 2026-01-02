@extends('layouts.master')

@section('title','Add Item')
@section('page-title','Add Item')

@php
    use App\Helpers\Permission;
@endphp

@section('content')

{{-- HARD GUARD (UI LEVEL) --}}
@if (!Permission::canManage('items'))

    <div class="alert alert-danger">
        Anda tidak memiliki akses ke halaman ini.
    </div>

@else

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="{{ route('master.items.store') }}">
            @csrf

            {{-- CODE --}}
            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text"
                       name="code"
                       class="form-control"
                       value="{{ old('code') }}"
                       required>
            </div>

            {{-- NAME --}}
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       required>
            </div>

            {{-- AISI --}}
            <div class="mb-3">
                <label class="form-label">AISI</label>
                <input type="text"
                       name="aisi"
                       class="form-control"
                       value="{{ old('aisi') }}">
            </div>

            {{-- STANDARD --}}
            <div class="mb-3">
                <label class="form-label">Standard</label>
                <select name="standard" class="form-select">
                    <option value="">-- Select --</option>
                    <option value="JIS"  {{ old('standard') === 'JIS' ? 'selected' : '' }}>JIS</option>
                    <option value="EN"   {{ old('standard') === 'EN' ? 'selected' : '' }}>EN</option>
                    <option value="ANSI" {{ old('standard') === 'ANSI' ? 'selected' : '' }}>ANSI</option>
                </select>
            </div>

            {{-- UNIT WEIGHT --}}
            <div class="mb-3">
                <label class="form-label">Unit Weight (kg)</label>
                <input type="number"
                       step="0.001"
                       name="unit_weight"
                       class="form-control"
                       value="{{ old('unit_weight') }}">
            </div>

            {{-- DEPARTMENT --}}
            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_code"
                        class="form-select"
                        required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->code }}"
                            {{ old('department_code') === $dept->code ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- CYCLE TIME --}}
            <div class="mb-3">
                <label class="form-label">Cycle Time (sec)</label>
                <input type="number"
                       name="cycle_time_sec"
                       class="form-control"
                       min="1"
                       value="{{ old('cycle_time_sec') }}"
                       required>
            </div>

            {{-- STATUS --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active"   {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- ACTION --}}
            <button type="submit" class="btn btn-primary">
                Save
            </button>

            <a href="{{ route('master.items.index') }}"
               class="btn btn-secondary ms-2">
                Cancel
            </a>

        </form>

    </div>
</div>

@endif

@endsection
