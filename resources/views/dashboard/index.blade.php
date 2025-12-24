@extends('layouts.master')

@section('title', 'Master Data Dashboard')
@section('page-title', 'Master Data Dashboard')

@section('content')

<div class="row g-4">

    {{-- MACHINES --}}
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Machines</h6>
                <h2>{{ $summary['machines']['total'] }}</h2>
                <small class="text-success">
                    Active: {{ $summary['machines']['active'] }}
                </small><br>
                <small class="text-danger">
                    Inactive: {{ $summary['machines']['inactive'] }}
                </small>
            </div>
        </div>
    </div>

    {{-- ITEMS --}}
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Items</h6>
                <h2>{{ $summary['items']['total'] }}</h2>
                <small class="text-success">
                    Active: {{ $summary['items']['active'] }}
                </small><br>
                <small class="text-danger">
                    Inactive: {{ $summary['items']['inactive'] }}
                </small>
            </div>
        </div>
    </div>

    {{-- OPERATORS --}}
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Operators</h6>
                <h2>{{ $summary['operators']['total'] }}</h2>
                <small class="text-success">
                    Active: {{ $summary['operators']['active'] }}
                </small><br>
                <small class="text-danger">
                    Inactive: {{ $summary['operators']['inactive'] }}
                </small>
            </div>
        </div>
    </div>

    {{-- DEPARTMENTS --}}
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Departments</h6>
                <h2>{{ $summary['departments']['total'] }}</h2>
            </div>
        </div>
    </div>

</div>

@endsection
