@extends('layouts.master')

@section('title', 'Edit Machine')
@section('header_title', 'Update Machine Details')

@section('content')

    <div class="max-w-4xl mx-auto px-1 pb-24 lg:pb-8">
        {{-- Header --}}
        <header class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Edit Master Machine</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Update specification and status for <span
                        class="font-bold text-slate-900 dark:text-white">{{ $machine->code }}</span></p>
            </div>
            <a href="{{ route('master.machines.index') }}"
                class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 hover:text-slate-700 transition-colors">
                <span class="material-icons">close</span>
            </a>
        </header>

        <form method="POST" action="{{ route('master.machines.update', $machine) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div
                class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6 lg:p-8 space-y-6">
                    {{-- Identification Section --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">01</span>
                            <h2 class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">
                                Machine Identification</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Machine
                                    Code</label>
                                <input type="text" value="{{ $machine->code }}" readonly
                                    class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-900/50 border-none rounded-2xl text-sm text-slate-500 cursor-not-allowed outline-none shadow-sm transition-all">
                                <p class="text-[9px] text-slate-400 mt-1 italic">Code cannot be changed.</p>
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Machine
                                    Name</label>
                                <input type="text" name="name" value="{{ old('name', $machine->name) }}" required
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none"
                                    placeholder="Friendly equipment name">
                            </div>
                        </div>
                    </section>

                    <hr class="border-slate-100 dark:border-slate-700">

                    {{-- Placement Section --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">02</span>
                            <h2 class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">
                                Placement & Status</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Department</label>
                                <div class="relative">
                                    <select name="department_code" required
                                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary appearance-none outline-none shadow-sm transition-all">
                                        <option value="">Select Dept</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->code }}"
                                                @selected($dept->code === $machine->department_code)>{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Production
                                    Line</label>
                                <div class="relative">
                                    <select name="line_code"
                                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary appearance-none outline-none shadow-sm transition-all">
                                        <option value="">None / Not Assigned</option>
                                        @foreach($lines as $line)
                                            <option value="{{ $line->code }}" @selected($line->code === $machine->line_code)>
                                                {{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Status</label>
                                <div class="relative">
                                    <select name="status"
                                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary appearance-none outline-none shadow-sm transition-all">
                                        <option value="active" @selected($machine->status === 'active')>Active</option>
                                        <option value="maintenance" @selected($machine->status === 'maintenance')>Maintenance
                                        </option>
                                        <option value="inactive" @selected($machine->status === 'inactive')>Inactive</option>
                                    </select>
                                    <span
                                        class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <hr class="border-slate-100 dark:border-slate-700">

                    {{-- System Logs (Read Only) --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 flex items-center justify-center font-bold text-xs">03</span>
                            <h2 class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Diagnostics (Read
                                Only)</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-60">
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Last
                                    Active Module</label>
                                <input type="text" value="{{ $machine->last_active_module ?? 'N/A' }}" readonly
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm text-slate-500 cursor-not-allowed outline-none">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Last
                                    Seen At</label>
                                <input type="text" value="{{ $machine->last_seen_at ?? 'Never' }}" readonly
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm text-slate-500 cursor-not-allowed outline-none">
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Footer / Actions --}}
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50 flex flex-col md:flex-row gap-3">
                    <button type="submit"
                        class="flex-1 md:flex-none h-12 px-10 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Update Machine
                    </button>
                    <a href="{{ route('master.machines.index') }}"
                        class="flex-1 md:flex-none h-12 px-10 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold flex items-center justify-center hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

@endsection