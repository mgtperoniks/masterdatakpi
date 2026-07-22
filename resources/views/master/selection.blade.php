@extends('layouts.master')

@section('title', $title)
@section('header_title', $title)

@section('content')
    <div class="max-w-4xl mx-auto py-4">
        
        {{-- Fast Search Workflow (Workflow A) - Only for Heat Numbers --}}
        @if($type === 'heat-numbers')
            <div x-data="heatNumberQuickSearch()" class="mb-6 bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-3">
                    <span class="material-icons text-primary text-xl">search</span>
                    <h2 class="font-extrabold text-sm text-slate-700 dark:text-slate-200 uppercase tracking-wider">Fast Search Heat Number</h2>
                </div>

                {{-- Search Box --}}
                <div class="relative">
                    <input type="text" x-model="query" @keydown.enter.prevent="performSearch"
                        placeholder="Search Heat Number (e.g. A223062601, 230626)..."
                        class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-3 pl-10 text-xs focus:ring-1 focus:ring-primary focus:border-primary font-bold uppercase tracking-wider">
                    <span class="material-icons absolute left-3 top-3 text-slate-400 text-lg">qr_code_scanner</span>
                    
                    <button type="button" @click="performSearch" :disabled="query.trim().length < 2"
                        class="absolute right-2 top-2 bg-primary hover:bg-primary/95 text-white font-bold text-[10px] px-4 py-1.5 rounded-lg disabled:opacity-50 transition-colors uppercase">
                        Cari
                    </button>
                </div>

                {{-- Loading Spinner --}}
                <div x-show="isLoading" class="text-center py-4" style="display: none;">
                    <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
                    <p class="text-xs text-slate-400 mt-2 font-medium">Mencari database...</p>
                </div>

                {{-- Results --}}
                <div x-show="!isLoading && hasSearched" style="display: none;" class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Hasil Pencarian</h3>
                        <button type="button" @click="resetSearch" class="text-[10px] text-red-500 hover:text-red-650 font-bold uppercase">Clear</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto pr-1 custom-scrollbar">
                        <template x-for="hn in results" :key="hn.id">
                            <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-150 dark:border-slate-800/80 hover:shadow-md transition-all flex flex-col justify-between gap-3">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-extrabold text-slate-800 dark:text-slate-200 text-sm tracking-wider" x-text="hn.heat_number"></h4>
                                        <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase" 
                                            :class="hn.status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600'"
                                            x-text="hn.status"></span>
                                    </div>
                                    <p class="text-[10px] font-semibold text-slate-500 mt-1 truncate" :title="hn.item_name" x-text="hn.item_name"></p>
                                    
                                    <div class="grid grid-cols-2 gap-x-2 gap-y-1.5 mt-3 pt-3 border-t border-slate-200/60 dark:border-slate-800 text-[10px]">
                                        <div>
                                            <span class="text-slate-400 block uppercase tracking-tighter">Category</span>
                                            <strong class="text-slate-700 dark:text-slate-300 font-bold" x-text="hn.category"></strong>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block uppercase tracking-tighter">Dept</span>
                                            <strong class="text-slate-700 dark:text-slate-300 font-bold" x-text="hn.department_code"></strong>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block uppercase tracking-tighter">Customer</span>
                                            <strong class="text-slate-700 dark:text-slate-300 font-bold" x-text="hn.customer"></strong>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block uppercase tracking-tighter">Size</span>
                                            <strong class="text-slate-700 dark:text-slate-300 font-bold" x-text="hn.size"></strong>
                                        </div>
                                    </div>
                                </div>

                                <a :href="hn.edit_url" 
                                    class="w-full text-center bg-primary hover:bg-primary/95 text-white font-extrabold text-[10px] py-2 rounded-lg transition-colors uppercase tracking-wider mt-2 block">
                                    Open Detail
                                </a>
                            </div>
                        </template>

                        <div x-show="results.length === 0" class="col-span-full py-6 text-center text-slate-400">
                            <span class="material-icons text-2xl mb-1">qr_code_2</span>
                            <p class="text-xs font-semibold">No matching Heat Numbers found.</p>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function heatNumberQuickSearch() {
                    return {
                        query: '',
                        results: [],
                        isLoading: false,
                        hasSearched: false,

                        async performSearch() {
                            const trimmed = this.query.trim();
                            if (trimmed.length < 2) return;

                            this.isLoading = true;
                            this.hasSearched = false;

                            try {
                                const res = await fetch(`{{ route('master.heat-numbers.search-api') }}?q=${encodeURIComponent(trimmed)}`);
                                this.results = await res.json();
                            } catch (e) {
                                console.error(e);
                                this.results = [];
                            } finally {
                                this.isLoading = false;
                                this.hasSearched = true;
                            }
                        },

                        resetSearch() {
                            this.query = '';
                            this.results = [];
                            this.hasSearched = false;
                            this.isLoading = false;
                        }
                    };
                }
            </script>
        @endif

        {{-- Browse by Department Workflow (Workflow B - Existing) --}}
        <div class="text-center mb-6">
            <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Pilih departemen untuk memfilter daftar
                {{ $type === 'items' ? 'Item' : 'Heat Number' }}</p>
        </div>

        <div class="flex flex-col gap-3">
            @foreach($departments as $dept)
                <a href="{{ route('master.' . $type . '.index', ['department_code' => $dept->code]) }}" class="group block">
                    <div
                        class="bg-white dark:bg-slate-800 px-6 py-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-primary hover:shadow-lg hover:shadow-primary/5 transition-all duration-300 flex items-center justify-between group-active:scale-[0.98]">

                        <div class="flex items-center gap-5">
                            <div
                                class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                                <span
                                    class="material-icons text-primary group-hover:text-white transition-colors">{{ $dept->icon }}</span>
                            </div>

                            <div class="text-left">
                                <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                    {{ $dept->name }}</h3>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span
                                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $dept->code }}</span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                    <span class="text-[10px] text-slate-500 font-medium">Klik untuk buka data</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-700/50 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-icons text-xl">chevron_right</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('master.dashboard') }}"
                class="inline-flex items-center gap-2 text-slate-400 hover:text-primary transition-colors font-medium text-sm group">
                <span class="material-icons text-base group-hover:-translate-x-1 transition-transform">arrow_back</span>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection