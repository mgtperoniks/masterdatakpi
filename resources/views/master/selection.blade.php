@extends('layouts.master')

@section('title', $title)
@section('header_title', $title)

@section('content')
    <div class="max-w-4xl mx-auto py-4">
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
                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
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