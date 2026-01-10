@extends('layouts.master')

@section('title', 'Master Operators')
@section('header_title', 'Master Operators')

@section('content')

    <div x-data="operatorList()">
        {{-- Header --}}
        <header class="mb-6 lg:flex lg:justify-between lg:items-center">
            <div class="mb-4 lg:mb-0">
                <h1 class="text-2xl font-bold tracking-tight">Master Operators</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Manage production personnel and employment history</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('master.operators.create') }}"
                    class="flex-1 lg:flex-none h-12 px-5 rounded-2xl bg-primary text-white shadow-lg shadow-primary/20 flex items-center justify-center gap-2 font-bold active:scale-95 transition-all">
                    <span class="material-icons text-lg">person_add</span>
                    Add Operator
                </a>
            </div>
        </header>

        {{-- Search & Filter --}}
        <div class="mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2 relative">
                    <span
                        class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input type="text" name="q" value="{{ request('q') }}"
                        class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm outline-none"
                        placeholder="Search operator code or name...">
                </div>

                <div class="relative">
                    <select name="department_code"
                        class="w-full pl-4 pr-10 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm appearance-none outline-none">
                        <option value="">All Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->code }}" {{ request('department_code') == $dept->code ? 'selected' : '' }}>
                                {{ $dept->code }} - {{ $dept->name }}
                            </option>
                        @endforeach
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
            @forelse ($operators as $op)
                <div
                    class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center justify-between group active:scale-[0.98] transition-transform">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-12 h-12 rounded-xl {{ $op->status === 'active' ? 'bg-indigo-50 dark:bg-indigo-900/30' : 'bg-slate-100 dark:bg-slate-900/50' }} flex items-center justify-center">
                            <span
                                class="material-icons-outlined {{ $op->status === 'active' ? 'text-primary' : 'text-slate-400' }}">person</span>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h3 class="font-bold text-slate-900 dark:text-white">{{ $op->name }}</h3>
                                <span
                                    class="px-2 py-0.5 rounded-full {{ $op->status === 'active' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }} text-[10px] font-bold uppercase tracking-tight">
                                    {{ $op->status }}
                                </span>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-0.5">
                                {{ $op->code }} | {{ $op->department_code }} | Seq: {{ $op->employment_seq }}
                            </p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 uppercase font-medium">Joined:
                                {{ $op->join_date }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-1">
                        <a href="{{ route('master.operators.edit', $op->id) }}"
                            class="p-2 rounded-full hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-400 dark:text-slate-500 transition-colors">
                            <span class="material-icons-outlined">edit</span>
                        </a>
                        @if ($op->status === 'active')
                            <button @click="openDeactivate({{ $op->id }}, '{{ $op->name }}', '{{ $op->code }}')"
                                class="p-2 rounded-full hover:bg-rose-50 text-slate-400 hover:text-rose-500 transition-colors">
                                <span class="material-icons-outlined">block</span>
                            </button>
                        @else
                            <form action="{{ route('master.operators.activate', $op->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="p-2 rounded-full hover:bg-emerald-50 text-slate-400 hover:text-emerald-500 transition-colors"
                                    onclick="return confirm('Reactivate this operator?')">
                                    <span class="material-icons-outlined">check_circle</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-20 text-center">
                    <span class="material-icons text-slate-200 text-6xl mb-4">groups</span>
                    <p class="text-slate-400">No operators found.</p>
                </div>
            @endforelse

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $operators->onEachSide(1)->links('layouts.partials.pagination_new') }}
            </div>
        </div>

        {{-- Deactivate Overlay --}}
        <div x-show="showOverlay" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;">

            <div class="bg-white dark:bg-slate-800 w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden"
                @click.away="showOverlay = false">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold dark:text-white">Deactivate Operator</h2>
                        <button @click="showOverlay = false" class="text-slate-400 hover:text-slate-600">
                            <span class="material-icons">close</span>
                        </button>
                    </div>

                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        You are deactivating <span class="font-bold text-slate-800 dark:text-white"
                            x-text="selectedOp.name"></span> (<span x-text="selectedOp.code"></span>). This will mark the
                        operator as inactive for KPI tracking.
                    </p>

                    <form :action="deactivateRoute" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1 block">Last
                                    Working Date</label>
                                <input type="date" name="inactive_at" required
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary">
                            </div>

                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1 block">Reason
                                    for Deactivation</label>
                                <textarea name="inactive_reason" required rows="3"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary"
                                    placeholder="Exit clearance, resignation, etc..."></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="showOverlay = false"
                                class="flex-1 py-3 rounded-xl font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 py-3 rounded-xl font-bold bg-rose-500 text-white shadow-lg shadow-rose-500/20 active:scale-95 transition-all">
                                Deactivate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function operatorList() {
            return {
                showOverlay: false,
                selectedOp: { id: null, name: '', code: '' },
                deactivateRoute: '',
                openDeactivate(id, name, code) {
                    this.selectedOp = { id, name, code };
                    this.deactivateRoute = `/masterdatakpi/public/index.php/master/operators/${id}/deactivate-confirm`;
                    this.showOverlay = true;
                }
            }
        }
    </script>
@endpush