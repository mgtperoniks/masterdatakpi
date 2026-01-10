@extends('layouts.master')

@section('title', 'Master Items')
@section('header_title', 'Master Items')

@section('content')

    {{-- Header Mobile & Tablet --}}
    <header class="mb-6 lg:flex lg:justify-between lg:items-center">
        <div class="mb-4 lg:mb-0">
            <h1 class="text-2xl font-bold tracking-tight">Master Items</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage product specifications and item master data</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('master.items.create') }}"
                class="flex-1 lg:flex-none h-12 px-5 rounded-2xl bg-primary text-white shadow-lg shadow-primary/20 flex items-center justify-center gap-2 font-bold active:scale-95 transition-all">
                <span class="material-icons text-lg">add</span>
                Add New
            </a>
            <a href="{{ route('master.items.import.form') }}"
                class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 shadow-sm active:scale-95 transition-all">
                <span class="material-icons">upload_file</span>
            </a>
        </div>
    </header>

    {{-- Search & Analytics Toggle --}}
    <div class="mb-6 space-y-4">
        <div class="p-1 bg-slate-200/50 dark:bg-slate-800 rounded-xl flex items-center max-w-md">
            <button
                class="flex-1 py-2 text-sm font-bold rounded-lg bg-white dark:bg-slate-700 shadow-sm text-slate-900 dark:text-white transition-all">
                Data Management
            </button>
            <a href="{{ route('master.trend-analytics') }}"
                class="flex-1 py-2 text-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-all">
                Trend Analytics
            </a>
        </div>

        <form method="GET" class="relative group">
            <span
                class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>
            <input type="text" name="q" value="{{ request('q') }}"
                class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm outline-none"
                placeholder="Search item code, name, specification...">
        </form>
    </div>

    {{-- Stats & Filter Info --}}
    <div class="flex justify-between items-center mb-4">
        <span
            class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">{{ $items->total() }}
            Total Entries</span>
        <div class="flex items-center text-xs font-medium text-primary">
            <span>Filter: {{ request('status') ? ucfirst(request('status')) : 'All Status' }}</span>
            <span class="material-icons-outlined text-xs ml-1">expand_more</span>
        </div>
    </div>

    {{-- List View --}}
    <div class="space-y-3 pb-24">
        @forelse ($items as $item)
            <div
                class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center justify-between group active:scale-[0.98] transition-transform">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 rounded-xl {{ $item->status === 'active' ? 'bg-indigo-50 dark:bg-indigo-900/30' : 'bg-slate-100 dark:bg-slate-900/50' }} flex items-center justify-center">
                        <span
                            class="material-icons-outlined {{ $item->status === 'active' ? 'text-primary' : 'text-slate-400' }}">inventory_2</span>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="font-bold text-slate-900 dark:text-white">{{ $item->name }}</h3>
                            <span
                                class="px-2 py-0.5 rounded-full {{ $item->status === 'active' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }} text-[10px] font-bold uppercase tracking-tight">
                                {{ $item->status }}
                            </span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-0.5">
                            {{ $item->code }} | CT: <span class="text-slate-600 dark:text-slate-300">{{ $item->cycle_time_sec }}s</span> | 
                            Weight: {{ number_format($item->unit_weight, 2) }}kg
                        </p>
                        @if($item->aisi)
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 uppercase font-medium">AISI:
                                {{ $item->aisi }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-1">
                    <a href="{{ route('master.items.edit', $item) }}"
                        class="p-2 rounded-full hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-400 dark:text-slate-500 transition-colors">
                        <span class="material-icons-outlined">edit</span>
                    </a>
                    @if($item->status === 'active')
                        <form action="{{ route('master.items.deactivate', $item) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="p-2 rounded-full hover:bg-rose-50 text-slate-400 hover:text-rose-500 transition-colors">
                                <span class="material-icons-outlined">block</span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('master.items.activate', $item) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="p-2 rounded-full hover:bg-emerald-50 text-slate-400 hover:text-emerald-500 transition-colors">
                                <span class="material-icons-outlined">check_circle</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-20 text-center">
                <span class="material-icons text-slate-200 text-6xl mb-4">inventory_2</span>
                <p class="text-slate-400">No items found matching your criteria.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $items->onEachSide(1)->links('layouts.partials.pagination_new') }}
        </div>
    </div>

@endsection