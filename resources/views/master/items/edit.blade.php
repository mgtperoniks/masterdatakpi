@extends('layouts.master')

@section('title','Edit Item')
@section('page-title','Edit Item')

@php
    use App\Helpers\Permission;
@endphp

@section('content')

{{-- HARD GUARD (UI LEVEL) --}}
@if (!Permission::canManage('items'))

    <div class="alert alert-danger">
        Akses ditolak.
    </div>

@else

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="{{ route('master.items.update', $item->id) }}">
            @csrf
            @method('PUT')

            {{-- CODE (READONLY) --}}
            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text"
                       class="form-control"
                       value="{{ $item->code }}"
                       readonly>
            </div>

            {{-- NAME --}}
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $item->name }}"
                       required>
            </div>

            {{-- AISI --}}
            <div class="mb-3">
                <label class="form-label">AISI</label>
                <input type="text"
                       name="aisi"
                       class="form-control"
                       value="{{ $item->aisi }}">
            </div>

            {{-- STANDARD --}}
            <div class="mb-3">
                <label class="form-label">Standard</label>
                <select name="standard" class="form-select">
                    @foreach(['JIS','EN','ANSI'] as $std)
                        <option value="{{ $std }}" @selected($item->standard === $std)>
                            {{ $std }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- UNIT WEIGHT --}}
            <div class="mb-3">
                <label class="form-label">Unit Weight (kg)</label>
                <input type="number"
                       step="0.001"
                       name="unit_weight"
                       class="form-control"
                       value="{{ $item->unit_weight }}">
            </div>

            {{-- DEPARTMENT --}}
            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_code"
                        class="form-select"
                        required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->code }}"
                            {{ $item->department_code === $dept->code ? 'selected' : '' }}>
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
                       value="{{ $item->cycle_time_sec }}"
                       required>
            </div>

            {{-- STATUS --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active"   @selected($item->status === 'active')>
                        Active
                    </option>
                    <option value="inactive" @selected($item->status === 'inactive')>
                        Inactive
                    </option>
                </select>
            </div>

            {{-- ACTION --}}
            <button type="submit" class="btn btn-primary">
                Update
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
