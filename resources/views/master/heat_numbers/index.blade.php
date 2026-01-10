@extends('layouts.master')

@section('title', 'Master Heat Numbers')
@section('header_title', 'Master Heat Numbers')

@section('content')

    {{-- Header --}}
    <header class="mb-6 lg:flex lg:justify-between lg:items-center">
        <div class="mb-4 lg:mb-0">
            <h1 class="text-2xl font-bold tracking-tight">Master Heat Numbers</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage heat numbers and casting records</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('master.heat-numbers.create') }}"
                class="flex-1 lg:flex-none h-12 px-5 rounded-2xl bg-primary text-white shadow-lg shadow-primary/20 flex items-center justify-center gap-2 font-bold active:scale-95 transition-all">
                <span class="material-icons text-lg">add</span>
                Add New
            </a>
            <a href="{{ route('master.heat-numbers.import') }}"
                class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 shadow-sm active:scale-95 transition-all">
                <span class="material-icons">upload_file</span>
            </a>
        </div>
    </header>

    {{-- Search & Filter --}}
    <div class="mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="md:col-span-2 relative">
                <span class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input type="text" name="q" value="{{ request('q') }}"
                    class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm outline-none"
                    placeholder="Search heat number, item, or production code...">
            </div>

            <div class="relative">
                <select name="status"
                    class="w-full pl-4 pr-10 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm appearance-none outline-none">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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

    {{-- List View --}}
    <div class="space-y-3 pb-24">
        @forelse ($heatNumbers as $hn)
            <div
                class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center justify-between group active:scale-[0.98] transition-transform">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 rounded-xl {{ $hn->status === 'active' ? 'bg-orange-50 dark:bg-orange-900/30' : 'bg-slate-100 dark:bg-slate-900/50' }} flex items-center justify-center">
                        <span
                            class="material-icons-outlined {{ $hn->status === 'active' ? 'text-orange-600' : 'text-slate-400' }}">qr_code</span>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="font-bold text-slate-900 dark:text-white">{{ $hn->heat_number }}</h3>
                            <span
                                class="px-2 py-0.5 rounded-full {{ $hn->status === 'active' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }} text-[10px] font-bold uppercase tracking-tight">
                                {{ $hn->status }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-1">
                            {{ $hn->item_name }} | {{ $hn->item_code }}
                        </p>
                        <div class="flex items-center gap-3 mt-1">
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase font-medium">Prod Code:
                                {{ $hn->kode_produksi ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase font-medium">Cor Qty: <span
                                    class="text-slate-700 dark:text-slate-200 font-bold">{{ number_format($hn->cor_qty) }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-1">
                    <a href="{{ route('master.heat-numbers.edit', $hn) }}"
                        class="p-2 rounded-full hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-400 dark:text-slate-500 transition-colors">
                        <span class="material-icons-outlined">edit</span>
                    </a>
                    @if ($hn->status === 'active')
                        <form action="{{ route('master.heat-numbers.deactivate', $hn) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="p-2 rounded-full hover:bg-rose-50 text-slate-400 hover:text-rose-500 transition-colors">
                                <span class="material-icons-outlined">block</span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('master.heat-numbers.activate', $hn) }}" method="POST" class="inline">
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
                <span class="material-icons text-slate-200 text-6xl mb-4">qr_code</span>
                <p class="text-slate-400">No heat numbers found.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $heatNumbers->onEachSide(1)->links('layouts.partials.pagination_new') }}
        </div>
    </div>

@endsection