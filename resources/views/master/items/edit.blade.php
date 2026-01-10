@extends('layouts.master')

@section('title', 'Edit Item')
@section('header_title', 'Update Item Details')

@section('content')

    <div class="max-w-4xl mx-auto px-1 pb-24 lg:pb-8">
        {{-- Header --}}
        <header class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Edit Master Item</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Update specification and operational details for <span
                        class="font-bold text-slate-900 dark:text-white">{{ $item->code }}</span></p>
            </div>
            <a href="{{ route('master.items.index') }}"
                class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 hover:text-slate-700 transition-colors">
                <span class="material-icons">close</span>
            </a>
        </header>

        <form method="POST" action="{{ route('master.items.update', $item) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div
                class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6 lg:p-8 space-y-6">
                    {{-- Basic Info Section --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">01</span>
                            <h2 class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">
                                Basic Information</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Item
                                    Code</label>
                                <input type="text" name="code" value="{{ old('code', $item->code) }}" readonly
                                    class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-900/50 border-none rounded-2xl text-sm text-slate-500 cursor-not-allowed outline-none shadow-sm transition-all"
                                    placeholder="e.g. ITEM-001">
                                <p class="text-[9px] text-slate-400 mt-1 italic">Code cannot be changed once created.</p>
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Item
                                    Name</label>
                                <input type="text" name="name" value="{{ old('name', $item->name) }}" required
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none"
                                    placeholder="Full item description">
                            </div>
                        </div>
                    </section>

                    <hr class="border-slate-100 dark:border-slate-700">

                    {{-- Specs Section --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">02</span>
                            <h2 class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">
                                Specifications</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">AISI</label>
                                <input type="text" name="aisi" value="{{ old('aisi', $item->aisi) }}"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none"
                                    placeholder="Steel grade">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Standard</label>
                                <input type="text" name="standard" value="{{ old('standard', $item->standard) }}"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none"
                                    placeholder="JIS, ASTM, etc">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Unit
                                    Weight (Kg)</label>
                                <input type="number" step="0.001" name="unit_weight"
                                    value="{{ old('unit_weight', $item->unit_weight) }}"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none"
                                    placeholder="0.000">
                            </div>
                        </div>
                    </section>

                    <hr class="border-slate-100 dark:border-slate-700">

                    {{-- Operational Section --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">03</span>
                            <h2 class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">
                                Production Settings</h2>
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
                                            <option value="{{ $dept->code }}" {{ old('department_code', $item->department_code) === $dept->code ? 'selected' : '' }}>{{ $dept->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Cycle
                                    Time (Sec)</label>
                                <input type="number" name="cycle_time_sec"
                                    value="{{ old('cycle_time_sec', $item->cycle_time_sec) }}" required min="1"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none"
                                    placeholder="e.g. 60">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Status</label>
                                <div class="relative">
                                    <select name="status"
                                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary appearance-none outline-none shadow-sm transition-all">
                                        <option value="active" {{ old('status', $item->status) === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $item->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <span
                                        class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Footer / Actions --}}
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50 flex flex-col md:flex-row gap-3">
                    <button type="submit"
                        class="flex-1 md:flex-none h-12 px-10 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Update Record
                    </button>
                    <a href="{{ route('master.items.index') }}"
                        class="flex-1 md:flex-none h-12 px-10 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold flex items-center justify-center hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

@endsection