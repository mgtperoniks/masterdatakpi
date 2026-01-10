@extends('layouts.master')

@section('title', 'Add Heat Number')
@section('header_title', 'Register Heat Number')

@section('content')

    <div class="max-w-4xl mx-auto px-1 pb-24 lg:pb-8">
        {{-- Header --}}
        <header class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Create Heat Number</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Add new tracking numbers for raw material batches</p>
            </div>
            <a href="{{ route('master.heat-numbers.index') }}"
                class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 hover:text-slate-700 transition-colors">
                <span class="material-icons">close</span>
            </a>
        </header>

        <form method="POST" action="{{ route('master.heat-numbers.store') }}" class="space-y-6">
            @csrf

            <div
                class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6 lg:p-8 space-y-6">
                    {{-- Tracking Section --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">01</span>
                            <h2 class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">
                                Tracking Information</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Heat
                                    Number</label>
                                <input type="text" name="heat_number" value="{{ old('heat_number') }}" required
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none"
                                    placeholder="e.g. HN-2026-001">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Item
                                    / Product</label>
                                <div class="relative">
                                    <select name="item_code" required
                                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary appearance-none outline-none shadow-sm transition-all">
                                        <option value="">Select Item</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->code }}" {{ old('item_code') === $item->code ? 'selected' : '' }}>{{ $item->code }} - {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <hr class="border-slate-100 dark:border-slate-700">

                    {{-- Batch Details --}}
                    <section>
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">02</span>
                            <h2 class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider text-[10px]">
                                Batch Details</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Kode
                                    Produksi</label>
                                <input type="text" name="kode_produksi" value="{{ old('kode_produksi') }}"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none"
                                    placeholder="Batch code">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Cor
                                    Qty</label>
                                <input type="number" name="cor_qty" value="{{ old('cor_qty', 0) }}" required min="0"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary transition-all shadow-sm outline-none">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">Status</label>
                                <div class="relative">
                                    <select name="status"
                                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary appearance-none outline-none shadow-sm transition-all">
                                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
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
                        Save Heat Number
                    </button>
                    <a href="{{ route('master.heat-numbers.index') }}"
                        class="flex-1 md:flex-none h-12 px-10 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold flex items-center justify-center hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

@endsection