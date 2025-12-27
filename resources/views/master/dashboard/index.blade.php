@extends('layouts.master')

@section('title', 'Master Data Dashboard')
@section('page-title', 'Master Data Health')

@section('content')

<div class="row g-3">

    {{-- ITEMS --}}
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Items</h6>
                <h2>{{ $items['total'] }}</h2>

                <small class="text-success">
                    Active: {{ $items['active'] }}
                </small><br>

                <small class="text-warning">
                    Inactive: {{ $items['inactive'] }}
                </small><br>

                @if ($items['invalid_cycle'] > 0)
                    <small class="text-danger">
                        Invalid Cycle: {{ $items['invalid_cycle'] }}
                    </small>
                @endif
            </div>
        </div>
    </div>

    {{-- MACHINES --}}
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Machines</h6>
                <h2>{{ $machines['total'] }}</h2>

                <small class="text-success">
                    Active: {{ $machines['active'] }}
                </small><br>

                <small class="text-warning">
                    Inactive: {{ $machines['inactive'] }}
                </small><br>

                @if ($machines['offline'] > 0)
                    <small class="text-danger">
                        Offline / Stale: {{ $machines['offline'] }}
                    </small>
                @endif
            </div>
        </div>
    </div>

    {{-- OPERATORS --}}
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Operators</h6>
                <h2>{{ $operators['total'] }}</h2>

                <small class="text-success">
                    Active: {{ $operators['active'] }}
                </small><br>

                <small class="text-warning">
                    Inactive: {{ $operators['inactive'] }}
                </small>
            </div>
        </div>
    </div>

    {{-- DEPARTMENTS --}}
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Departments</h6>
                <h2>{{ $departments['total'] }}</h2>
            </div>
        </div>
    </div>

</div>

@endsection
