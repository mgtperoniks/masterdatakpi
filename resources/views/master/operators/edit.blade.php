@extends('layouts.master')

@section('title', 'Edit Operator')
@section('page-title', 'Edit Operator')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form
            method="POST"
            action="{{ route('master.operators.update', $operator->id) }}"
        >
            @csrf
            @method('PUT')

            {{-- Operator Code (readonly) --}}
            <div class="mb-3">
                <label class="form-label">Code</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $operator->code }}"
                    readonly
                >
            </div>

            {{-- Operator Name --}}
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $operator->name) }}"
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
                            @selected(old('department_code', $operator->department_code) === $dept->code)
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
                    value="{{ old('join_date', optional($operator->join_date)->format('Y-m-d')) }}"
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
                    value="{{ old('position', $operator->position) }}"
                    required
                >
            </div>

            {{-- Gender --}}
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">-- Optional --</option>
                    <option value="male"
                        @selected(old('gender', $operator->gender) === 'male')
                    >
                        Male
                    </option>
                    <option value="female"
                        @selected(old('gender', $operator->gender) === 'female')
                    >
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
                    <option value="PKWT"
                        @selected(old('employment_type', $operator->employment_type) === 'PKWT')
                    >
                        PKWT
                    </option>
                    <option value="PKWTT"
                        @selected(old('employment_type', $operator->employment_type) === 'PKWTT')
                    >
                        PKWTT
                    </option>
                    <option value="OUTSOURCE"
                        @selected(old('employment_type', $operator->employment_type) === 'OUTSOURCE')
                    >
                        Outsource
                    </option>
                </select>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active"
                        @selected(old('status', $operator->status) === 'active')
                    >
                        Active
                    </option>
                    <option value="inactive"
                        @selected(old('status', $operator->status) === 'inactive')
                    >
                        Inactive
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
                    Update
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
