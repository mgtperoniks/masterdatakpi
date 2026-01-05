@extends('layouts.master')

@section('title', 'Add Operator')
@section('page-title', 'Add Operator')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="{{ route('master.operators.store') }}">
            @csrf

            {{-- Operator Code --}}
            <div class="mb-3">
                <label class="form-label">Code</label>
                <input
                    type="text"
                    name="code"
                    class="form-control"
                    value="{{ old('code') }}"
                    required
                >
            </div>

            {{-- Operator Name --}}
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            {{-- Department --}}
            <div class="mb-3">
                <label class="form-label">Department</label>
                <select
                    name="department_code"
                    class="form-select"
                    required
                >
                    <option value="">-- Select Department --</option>
                    @foreach ($departments as $dept)
                        <option
                            value="{{ $dept->code }}"
                            @selected(old('department_code') == $dept->code)
                        >
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Join Date --}}
            <div class="mb-3">
                <label class="form-label">Join Date</label>
                <input
                    type="date"
                    name="join_date"
                    class="form-control"
                    value="{{ old('join_date') }}"
                    required
                >
            </div>

            {{-- Position --}}
            <div class="mb-3">
                <label class="form-label">Position</label>
                <input
                    type="text"
                    name="position"
                    class="form-control"
                    value="{{ old('position') }}"
                    required
                >
            </div>

            {{-- Gender --}}
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">-- Optional --</option>
                    <option value="male" @selected(old('gender') === 'male')>
                        Male
                    </option>
                    <option value="female" @selected(old('gender') === 'female')>
                        Female
                    </option>
                </select>
            </div>

            {{-- Employment Type --}}
            <div class="mb-3">
                <label class="form-label">Employment Type</label>
                <select
                    name="employment_type"
                    class="form-select"
                    required
                >
                    <option value="">-- Select Type --</option>
                    <option value="PKWT" @selected(old('employment_type') === 'PKWT')>
                        PKWT
                    </option>
                    <option value="PKWTT" @selected(old('employment_type') === 'PKWTT')>
                        PKWTT
                    </option>
                    <option value="OUTSOURCE" @selected(old('employment_type') === 'OUTSOURCE')>
                        Outsource
                    </option>
                </select>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-end">
                <a
                    href="{{ route('master.operators.index') }}"
                    class="btn btn-secondary me-2"
                >
                    Cancel
                </a>
                <button class="btn btn-primary">
                    Save
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
