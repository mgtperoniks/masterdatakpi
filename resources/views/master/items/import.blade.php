@extends('layouts.master')

@section('title', 'Bulk Import Items')
@section('header_title', 'Excel Import Data')

@push('styles')
    <style>
        .handsontable {
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
        }

        .handsontable th {
            background-color: #f8fafc !important;
            font-weight: 700 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.025em !important;
            font-size: 10px !important;
            padding: 12px 0 !important;
        }

        .handsontable td {
            padding: 8px !important;
            vertical-align: middle !important;
        }

        .htCore td {
            border-color: #f1f5f9 !important;
        }

        .handsontable .htAutocompleteArrow {
            color: #94a3b8;
        }
    </style>
@endpush

@section('content')

    <div class="max-w-6xl mx-auto px-1 pb-24 lg:pb-8">
        {{-- Header --}}
        <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('master.items.index') }}" class="text-slate-400 hover:text-primary transition-colors">
                        <span class="material-icons text-xl">arrow_back</span>
                    </a>
                    <h1 class="text-2xl font-bold tracking-tight">Bulk Import Items</h1>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 ml-8">Paste your data directly from Excel or CSV files
                </p>
            </div>

            <div class="flex gap-2 ml-8 md:ml-0">
                <button id="saveItemBtn"
                    class="h-12 px-6 rounded-2xl bg-primary text-white shadow-lg shadow-primary/20 flex items-center gap-2 font-bold active:scale-95 transition-all">
                    <span class="material-icons text-lg">cloud_upload</span>
                    Save Records
                </button>
            </div>
        </header>

        {{-- Info Card --}}
        <div
            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 rounded-2xl p-4 mb-6 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex-shrink-0 flex items-center justify-center">
                <span class="material-icons text-lg">info</span>
            </div>
            <div>
                <h4 class="font-bold text-blue-900 dark:text-blue-200 text-sm">Quick Instructions</h4>
                <p class="text-xs text-blue-700 dark:text-blue-300 mt-0.5">Copy your Excel range and paste it inside the
                    grid below. The required columns are: <strong class="underline">CODE</strong>, <strong
                        class="underline">NAME</strong>, <strong class="underline">DEPT CODE</strong>, and <strong
                        class="underline">STATUS</strong>.</p>
                <div
                    class="mt-2 p-2 bg-white/50 dark:bg-slate-800/50 rounded-lg font-mono text-[9px] text-blue-800 dark:text-blue-300 border border-blue-100 dark:border-blue-800/30">
                    code, name, aisi, standard, unit_weight, department_code, cycle_time_sec, status
                </div>
            </div>
        </div>

        {{-- Grid Container --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-6">
            <div class="p-2">
                <div id="item-grid-container" style="width: 100%; height: 500px;" class="overflow-hidden rounded-2xl"></div>
            </div>
        </div>

        {{-- Error Log --}}
        <div id="errorLog" style="display: none;" class="animate-in fade-in slide-in-from-top-4 duration-300">
            <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800/50 rounded-2xl p-5">
                <div class="flex items-center gap-3 text-rose-600 mb-3 font-bold">
                    <span class="material-icons">report_problem</span>
                    Some items failed to import
                </div>
                <ul id="errorList" class="space-y-1 ml-9 list-disc text-sm text-rose-600/80 dark:text-rose-400"></ul>
            </div>
        </div>

        {{-- Configuration for JS --}}
        <div id="import-config" data-save-url="{{ route('master.items.bulk-store') }}"
            data-redirect-url="{{ route('master.items.index') }}" style="display: none;">
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Local scripts loaded via app.js --}}
@endpush