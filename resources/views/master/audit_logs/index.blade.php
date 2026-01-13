@extends('layouts.master')

@section('title', 'Audit Logs')
@section('header_title', 'Audit Logs')

@section('content')

    {{-- Header --}}
    <header class="mb-6 lg:flex lg:justify-between lg:items-center">
        <div class="mb-4 lg:mb-0">
            <h1 class="text-2xl font-bold tracking-tight">Audit Logs</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Track system activities and changes across all master data</p>
        </div>
    </header>

    {{-- Search & Filter --}}
    <div class="mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="relative">
                <select name="table_name" 
                    class="w-full pl-4 pr-10 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm appearance-none outline-none">
                    <option value="">All Tables</option>
                    @foreach ($tables as $tbl)
                        <option value="{{ $tbl }}" {{ request('table_name') === $tbl ? 'selected' : '' }}>
                            {{ $tbl }}
                        </option>
                    @endforeach
                </select>
                <span class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
            </div>

            <div class="relative">
                <select name="action" 
                    class="w-full pl-4 pr-10 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm appearance-none outline-none">
                    <option value="">All Actions</option>
                    <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="sync" {{ request('action') === 'sync' ? 'selected' : '' }}>Sync</option>
                </select>
                <span class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
            </div>

            <div class="relative">
                <input type="date" name="date" value="{{ request('date') }}"
                    class="w-full pl-4 pr-4 py-3 bg-white dark:bg-slate-800 border-none rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-primary transition-all text-sm outline-none">
            </div>

            <button type="submit"
                class="h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-primary hover:text-white transition-all">
                Filter
            </button>
        </form>
    </div>

    {{-- List View --}}
    <div class="space-y-3 pb-24">
        @forelse ($logs as $log)
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 transition-all">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start md:items-center space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center shrink-0">
                            @php
                                $actionIcon = match($log->action) {
                                    'create' => 'add_circle_outline',
                                    'update' => 'edit',
                                    'deactivate', 'delete' => 'remove_circle_outline',
                                    'sync' => 'sync',
                                    default => 'info'
                                };
                                $actionColor = match($log->action) {
                                    'create' => 'text-emerald-500',
                                    'update' => 'text-amber-500',
                                    'deactivate', 'delete' => 'text-rose-500',
                                    'sync' => 'text-blue-500',
                                    default => 'text-slate-400'
                                };
                            @endphp
                            <span class="material-icons-outlined {{ $actionColor }}">{{ $actionIcon }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-tight">{{ $log->table_name }}</span>
                                <span class="text-xs font-mono bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded text-slate-600 dark:text-slate-300">{{ $log->record_code }}</span>
                                <span class="text-[10px] font-bold uppercase py-0.5 px-2 rounded-full border 
                                    @if($log->action === 'create') border-emerald-200 bg-emerald-50 text-emerald-600 
                                    @elseif($log->action === 'update') border-amber-200 bg-amber-50 text-amber-600 
                                    @elseif(in_array($log->action, ['delete', 'deactivate'])) border-rose-200 bg-rose-50 text-rose-600 
                                    @else border-blue-200 bg-blue-50 text-blue-600 @endif">
                                    {{ $log->action }}
                                </span>
                            </div>
                            <h4 class="font-semibold text-slate-900 dark:text-white mt-1 break-words">{{ $log->description }}</h4>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2">
                                <div class="flex items-center text-[11px] text-slate-500">
                                    <span class="material-icons text-[14px] mr-1">person</span>
                                    {{ $log->user ? $log->user->name : 'System' }}
                                </div>
                                <div class="flex items-center text-[11px] text-slate-500">
                                    <span class="material-icons text-[14px] mr-1">schedule</span>
                                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                                </div>
                                <div class="flex items-center text-[11px] text-slate-500">
                                    <span class="material-icons text-[14px] mr-1">monitor</span>
                                    {{ $log->source }} ({{ $log->ip_address ?? '-' }})
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-end md:self-center">
                        @if($log->old_values || $log->new_values)
                            <div x-data="{ open: false }" class="w-full md:w-auto">
                                <button @click="open = !open" 
                                    class="text-[11px] font-bold text-primary hover:bg-primary/5 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                                    <span class="material-icons text-[16px]">history</span>
                                    <span x-text="open ? 'HIDE CHANGES' : 'VIEW CHANGES'"></span>
                                </button>
                                
                                <template x-if="open">
                                    <div class="mt-3 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-100 dark:border-slate-800 text-[10px] font-mono space-y-3 overflow-hidden">
                                        @if($log->old_values)
                                            <div>
                                                <div class="text-rose-500 font-bold mb-1 uppercase tracking-wider">Previous State:</div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1">
                                                    @foreach($log->old_values as $key => $val)
                                                        <div class="flex justify-between border-b border-rose-100 dark:border-rose-900/30 pb-1">
                                                            <span class="text-slate-400">{{ $key }}:</span>
                                                            <span class="text-rose-700 dark:text-rose-400 text-right">{{ is_array($val) ? json_encode($val) : $val }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if($log->new_values)
                                            <div>
                                                <div class="text-emerald-500 font-bold mb-1 uppercase tracking-wider">New State:</div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1">
                                                    @foreach($log->new_values as $key => $val)
                                                        <div class="flex justify-between border-b border-emerald-100 dark:border-emerald-900/30 pb-1">
                                                            <span class="text-slate-400">{{ $key }}:</span>
                                                            <span class="text-emerald-700 dark:text-emerald-400 text-right">{{ is_array($val) ? json_encode($val) : $val }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </template>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 text-center">
                <span class="material-icons text-slate-200 text-6xl mb-4">history</span>
                <p class="text-slate-400">No audit logs found.</p>
            </div>
        @endforelse
    </div>

@endsection
