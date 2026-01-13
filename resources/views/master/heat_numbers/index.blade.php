@extends('layouts.master')

@section('title', 'Master Heat Numbers')
@section('header_title', 'Master Heat Numbers')

@section('content')

    {{-- Header --}}
    <header class="mb-6 lg:flex lg:justify-between lg:items-center">
        <div class="mb-4 lg:mb-0">
            <h1 class="text-2xl font-bold tracking-tight">Master Heat Numbers</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage heat numbers organized by casting date (Daily
                Batches)</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('master.heat-numbers.create') }}"
                class="flex-1 lg:flex-none h-12 px-5 rounded-2xl bg-primary text-white shadow-lg shadow-primary/20 flex items-center justify-center gap-2 font-bold active:scale-95 transition-all">
                <span class="material-icons text-lg">add</span>
                Add New
            </a>
            <a href="{{ route('master.heat-numbers.import') }}"
                class="h-12 px-5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400 shadow-sm active:scale-95 transition-all font-bold">
                <span class="material-icons">upload_file</span>
                Bulk Import
            </a>
        </div>
    </header>

    {{-- Filter --}}
    <div class="mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="relative">
                <select name="month"
                    class="w-full pl-4 pr-10 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm appearance-none outline-none">
                    <option value="">All Months</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </select>
                <span
                    class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
            </div>

            <div class="relative">
                <select name="year"
                    class="w-full pl-4 pr-10 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm appearance-none outline-none">
                    <option value="">All Years</option>
                    @for ($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
                <span
                    class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
            </div>

            <button type="submit"
                class="h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-primary hover:text-white transition-all">
                Filter
            </button>
        </form>
    </div>

    {{-- Daily Batches List --}}
    <div class="space-y-3 pb-24">
        @forelse ($dailyBatches as $batch)
            <a href="{{ route('master.heat-numbers.daily-details', $batch->heat_date->format('Y-m-d')) }}"
                class="block bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/50 hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 rounded-xl bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center">
                            <span class="material-icons-outlined text-orange-600 text-2xl">event</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 dark:text-white">
                                {{ $batch->heat_date->format('d F Y') }}
                            </h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-0.5">
                                {{ $batch->heat_date->isoFormat('dddd') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="text-right">
                            <p class="text-2xl font-bold text-primary">{{ number_format($batch->total_records) }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-tight font-medium">Heat Numbers</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-emerald-600">{{ number_format($batch->total_cor_qty) }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-tight font-medium">Total Cor Qty</p>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-700 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-icons text-slate-400 group-hover:text-white">chevron_right</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="py-20 text-center">
                <span class="material-icons text-slate-200 text-6xl mb-4">qr_code</span>
                <p class="text-slate-400">No heat number batches found.</p>
                <a href="{{ route('master.heat-numbers.import') }}"
                    class="mt-4 inline-block text-primary font-bold hover:underline">
                    Start by importing your first batch →
                </a>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $dailyBatches->onEachSide(1)->links('layouts.partials.pagination_new') }}
        </div>
    </div>

@endsection