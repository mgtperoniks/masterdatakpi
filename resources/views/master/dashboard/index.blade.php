@extends('layouts.master')

@section('title', 'Dashboard')
@section('header_title', 'Master Data Dashboard')

@section('content')

    <div class="space-y-6 pb-20">
        {{-- Header --}}
        <section>
            <h2 class="text-2xl font-bold dark:text-white">Overview</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Status and statistics of master data records</p>
        </section>

        {{-- Cards Grid --}}
        <section class="flex gap-4 overflow-x-auto custom-scrollbar pb-2 -mx-5 px-5 lg:mx-0 lg:px-0">
            {{-- Items Card --}}
            <div
                class="min-w-[160px] flex-shrink-0 lg:flex-1 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Items</span>
                    <span class="material-icons text-primary bg-primary/10 p-1.5 rounded-lg text-lg">inventory_2</span>
                </div>
                <div class="text-3xl font-bold mb-3">{{ $counts['items_total'] ?? 0 }}</div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[10px] font-medium text-slate-500">{{ $counts['items_active'] ?? 0 }}
                            Active</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="text-[10px] font-medium text-slate-500">{{ $counts['items_inactive'] ?? 0 }}
                            Inactive</span>
                    </div>
                </div>
            </div>

            {{-- Machines Card --}}
            <div
                class="min-w-[160px] flex-shrink-0 lg:flex-1 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Machines</span>
                    <span
                        class="material-icons text-purple-600 bg-purple-50 p-1.5 rounded-lg text-lg">settings_input_component</span>
                </div>
                <div class="text-3xl font-bold mb-3">{{ $counts['machines_total'] ?? 0 }}</div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[10px] font-medium text-slate-500">{{ $counts['machines_active'] ?? 0 }}
                            Active</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="text-[10px] font-medium text-slate-500">{{ $counts['machines_inactive'] ?? 0 }}
                            Inactive</span>
                    </div>
                </div>
            </div>

            {{-- Operators Card --}}
            <div
                class="min-w-[160px] flex-shrink-0 lg:flex-1 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Operators</span>
                    <span class="material-icons text-emerald-600 bg-emerald-50 p-1.5 rounded-lg text-lg">groups</span>
                </div>
                <div class="text-3xl font-bold mb-3">{{ $counts['operators_total'] ?? 0 }}</div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[10px] font-medium text-slate-500">{{ $counts['operators_active'] ?? 0 }}
                            Active</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="text-[10px] font-medium text-slate-500">{{ $counts['operators_inactive'] ?? 0 }}
                            Inactive</span>
                    </div>
                </div>
            </div>

            {{-- Lines Card --}}
            <div
                class="min-w-[160px] flex-shrink-0 lg:flex-1 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Lines</span>
                    <span class="material-icons text-rose-600 bg-rose-50 p-1.5 rounded-lg text-lg">reorder</span>
                </div>
                <div class="text-3xl font-bold mb-3">{{ $counts['lines_total'] ?? 0 }}</div>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[10px] font-medium text-slate-500">{{ $counts['lines_active'] ?? 0 }} Active</span>
                </div>
            </div>

            {{-- Heat Numbers Card --}}
            <div
                class="min-w-[160px] flex-shrink-0 lg:flex-1 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Heat Numbers</span>
                    <span class="material-icons text-orange-600 bg-orange-50 p-1.5 rounded-lg text-lg">qr_code</span>
                </div>
                <div class="text-3xl font-bold mb-3">{{ $counts['heat_numbers_total'] ?? 0 }}</div>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[10px] font-medium text-slate-500">{{ $counts['heat_numbers_active'] ?? 0 }}
                        Active</span>
                </div>
            </div>
        </section>

        {{-- Main Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Machine Distribution --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">Machine Distribution</h3>
                        <p class="text-slate-400 text-xs mt-0.5">Records by active departments</p>
                    </div>
                    <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-xl text-purple-600">
                        <span class="material-icons text-sm">precision_manufacturing</span>
                    </div>
                </div>
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="machineDeptChart"></canvas>
                </div>
            </div>

            {{-- Operator Distribution --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">Operator Distribution</h3>
                        <p class="text-slate-400 text-xs mt-0.5">Personnel count by department</p>
                    </div>
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600">
                        <span class="material-icons text-sm">person</span>
                    </div>
                </div>
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="operatorDeptChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Status Distribution Full Width --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-1">Status Overview</h3>
            <p class="text-slate-400 text-xs mb-8">Active vs Inactive across categories</p>
            <div class="h-64">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        {{-- Bottom Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Quick Links --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="font-bold text-lg mb-4 text-slate-800 dark:text-white">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('master.items.create') }}"
                        class="flex flex-col items-center gap-2 p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl hover:bg-primary/5 hover:text-primary transition-all text-center border border-transparent hover:border-primary/20">
                        <span class="material-icons text-primary">add_circle</span>
                        <span class="text-[10px] font-bold">New Item</span>
                    </a>
                    <a href="{{ route('master.heat-numbers.import') }}"
                        class="flex flex-col items-center gap-2 p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl hover:bg-primary/5 hover:text-primary transition-all text-center border border-transparent hover:border-primary/20">
                        <span class="material-icons text-primary">upload_file</span>
                        <span class="text-[10px] font-bold">Import Heat</span>
                    </a>
                </div>
            </div>

            {{-- Trend Action --}}
            <div class="lg:col-span-2">
                <div
                    class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 h-full flex flex-col justify-center">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div>
                            <h3 class="font-bold text-xl text-emerald-600 flex items-center gap-3">
                                <div class="p-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl">
                                    <span class="material-icons">insights</span>
                                </div>
                                Trend Analytics
                            </h3>
                            <p class="text-sm text-slate-500 mt-2 max-w-sm">Deep dive into production vs reject performance
                                over the last 26 weeks.</p>
                        </div>
                        <a href="{{ route('master.trend-analytics') }}"
                            class="w-full md:w-auto bg-emerald-600 text-white font-bold px-8 py-4 rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 active:scale-95 hover:bg-emerald-700 transition-all">
                            Open Dashboard
                            <span class="material-icons">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartColors = [
                '#6366f1', '#a855f7', '#ec4899', '#f97316', '#10b981', '#06b6d4', '#3b82f6', '#ef4444',
                '#8b5cf6', '#d946ef', '#f43f5e', '#f59e0b', '#22c55e', '#0ea5e9', '#6366f1'
            ];

            // 1. Machine Distribution (Only departments with data)
            const machineCtx = document.getElementById('machineDeptChart').getContext('2d');
            const machineLabels = @json($machineDeptDist->pluck('name'));
            const machineData = @json($machineDeptDist->pluck('machines_count'));

            new Chart(machineCtx, {
                type: 'doughnut',
                data: {
                    labels: machineLabels,
                    datasets: [{
                        data: machineData,
                        backgroundColor: chartColors,
                        borderWidth: 2,
                        borderColor: 'transparent',
                        hoverOffset: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // 2. Operator Distribution (Only departments with data)
            const operatorCtx = document.getElementById('operatorDeptChart').getContext('2d');
            const operatorLabels = @json($operatorDeptDist->pluck('name'));
            const operatorData = @json($operatorDeptDist->pluck('operators_count'));

            new Chart(operatorCtx, {
                type: 'doughnut',
                data: {
                    labels: operatorLabels,
                    datasets: [{
                        data: operatorData,
                        backgroundColor: chartColors,
                        borderWidth: 2,
                        borderColor: 'transparent',
                        hoverOffset: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // 3. Status Chart (Bar)
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'bar',
                data: {
                    labels: ['Items', 'Machines', 'Operators'],
                    datasets: [
                        {
                            label: 'Active',
                            data: [
                                        {{ $counts['items_active'] ?? 0 }},
                                        {{ $counts['machines_active'] ?? 0 }},
                                {{ $counts['operators_active'] ?? 0 }}
                            ],
                            backgroundColor: '#10b981',
                            borderRadius: 8,
                            barThickness: 40,
                        },
                        {
                            label: 'Inactive',
                            data: [
                                        {{ $counts['items_inactive'] ?? 0 }},
                                        {{ $counts['machines_inactive'] ?? 0 }},
                                {{ $counts['operators_inactive'] ?? 0 }}
                            ],
                            backgroundColor: '#f59e0b',
                            borderRadius: 8,
                            barThickness: 40,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, boxWidth: 8, font: { weight: 'bold' } }
                        }
                    }
                }
            });
        });
    </script>
@endpush