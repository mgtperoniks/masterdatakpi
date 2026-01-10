@extends('layouts.master')

@section('title', 'Trend Analytics')
@section('header_title', 'Master Items Analytics')

@section('content')

    <div class="px-1 pb-24 lg:pb-8 space-y-6" x-data="trendAnalytics()">
        {{-- Header Section --}}
        <header class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Trend Analytics</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Production & Reject Trend Analysis (Last 26 Weeks)</p>
            </div>

            <div class="bg-slate-200/50 dark:bg-slate-800/50 p-1 rounded-xl flex lg:w-96">
                <a href="{{ route('master.items.index') }}"
                    class="flex-1 py-1.5 text-center text-sm font-medium rounded-lg text-slate-500 dark:text-slate-400 hover:text-slate-700">
                    Data Management
                </a>
                <button
                    class="flex-1 py-1.5 text-sm font-semibold rounded-lg bg-white dark:bg-slate-700 shadow-sm text-primary">
                    Trend Analytics
                </button>
            </div>
        </header>

        {{-- Filter Card --}}
        <section
            class="bg-card-light dark:bg-card-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1 block">Select
                        Item</label>
                    <div class="relative">
                        <span
                            class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                        <select x-model="filters.item_code"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary appearance-none">
                            <option value="">-- All Items --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->code }}">{{ $item->code }} - {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-end">
                    <button @click="generateReport()" :disabled="loading"
                        class="w-full bg-primary text-white font-semibold py-3 rounded-xl flex items-center justify-center gap-2 active:scale-[0.98] transition-transform disabled:opacity-50">
                        <span class="material-icons-round text-lg" :class="loading ? 'animate-spin' : ''"
                            x-text="loading ? 'sync' : 'analytics'"></span>
                        <span x-text="loading ? 'Generating...' : 'Generate Report'"></span>
                    </button>
                </div>
            </div>
        </section>

        {{-- Summary Stats --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div
                class="bg-card-light dark:bg-card-dark p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Avg Production / Week</p>
                <h3 class="text-2xl font-bold mt-1" x-text="stats.avg_prod.toLocaleString()">0</h3>
                <div class="flex items-center gap-1 mt-2 text-[10px] text-emerald-500 font-semibold">
                    <span class="material-icons-round text-sm">trending_up</span>
                    Trend analysis period
                </div>
            </div>
            <div
                class="bg-card-light dark:bg-card-dark p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Avg Reject / Week</p>
                <h3 class="text-2xl font-bold mt-1" x-text="stats.avg_rej.toLocaleString()">0</h3>
                <div class="flex items-center gap-1 mt-2 text-[10px] text-primary font-semibold">
                    <span class="material-icons-round text-sm">insights</span>
                    Weekly performance
                </div>
            </div>
            <div
                class="bg-card-light dark:bg-card-dark p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Data Points</p>
                <h3 class="text-2xl font-bold mt-1">26 Weeks</h3>
                <div class="flex items-center gap-1 mt-2 text-[10px] text-slate-400 font-semibold uppercase">
                    <span class="material-icons-round text-sm">event</span>
                    Rolling period
                </div>
            </div>
        </div>

        {{-- Line Chart Section --}}
        <section
            class="bg-card-light dark:bg-card-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-bold text-slate-800 dark:text-slate-100">Weekly Trend - Line Chart</h2>
                    <p class="text-[10px] text-slate-500">Production vs Reject over 26 weeks</p>
                </div>
                <div class="flex gap-2">
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 rounded-full bg-primary"></div>
                        <span class="text-[8px] font-bold text-slate-400 uppercase">Prod.</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                        <span class="text-[8px] font-bold text-slate-400 uppercase">Reject</span>
                    </div>
                </div>
            </div>
            <div class="h-64 lg:h-96 w-full relative">
                <canvas id="trendChart"></canvas>
            </div>
        </section>

        {{-- Bar Chart Comparison --}}
        <section
            class="bg-card-light dark:bg-card-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <h2 class="font-bold text-slate-800 dark:text-slate-100">Weekly Comparison - Bar Chart</h2>
            <p class="text-[10px] text-slate-500 mb-6">Week-over-week production performance</p>
            <div class="h-64 w-full relative">
                <canvas id="comparisonChart"></canvas>
            </div>
        </section>
    </div>

@endsection

@push('scripts')
    <script>
        function trendAnalytics() {
            return {
                loading: false,
                filters: {
                    item_code: ''
                },
                stats: {
                    avg_prod: 0,
                    avg_rej: 0
                },
                charts: {
                    trend: null,
                    comparison: null
                },
                init() {
                    this.generateReport();
                },
                async generateReport() {
                    this.loading = true;
                    try {
                        const response = await fetch('{{ route("master.trend-analytics.report") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.filters)
                        });
                        const data = await response.json();

                        this.stats.avg_prod = data.avg_prod;
                        this.stats.avg_rej = data.avg_rej;

                        this.updateCharts(data);
                    } catch (e) {
                        Swal.fire('Error', 'Failed to fetch analytics data.', 'error');
                    } finally {
                        this.loading = false;
                    }
                },
                updateCharts(data) {
                    // Line Chart
                    if (this.charts.trend) this.charts.trend.destroy();
                    const trendCtx = document.getElementById('trendChart').getContext('2d');
                    this.charts.trend = new Chart(trendCtx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'Production',
                                    data: data.production,
                                    borderColor: '#4F46E5',
                                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 2
                                },
                                {
                                    label: 'Reject',
                                    data: data.reject,
                                    borderColor: '#EF4444',
                                    backgroundColor: 'transparent',
                                    tension: 0.4,
                                    pointRadius: 2
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { grid: { borderDash: [5, 5] }, ticks: { font: { size: 10 } } },
                                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                            }
                        }
                    });

                    // Bar Chart
                    if (this.charts.comparison) this.charts.comparison.destroy();
                    const compCtx = document.getElementById('comparisonChart').getContext('2d');
                    this.charts.comparison = new Chart(compCtx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Production',
                                data: data.production,
                                backgroundColor: '#4F46E5',
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { grid: { display: false } },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                }
            };
        }
    </script>
@endpush