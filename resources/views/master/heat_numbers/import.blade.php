@extends('layouts.master')

@section('title', 'Bulk Import Heat Numbers')
@section('header_title', 'Excel Import Data')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
    <style>
        .handsontable {
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
        }

        .handsontable th {
            background-color: #f8fafc !important;
            font-weight: 700 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.025em !important;
            font-size: 10px !important;
            padding: 12px 0 !important;
        }

        .handsontable td {
            padding: 8px !important;
            vertical-align: middle !important;
        }

        .htCore td {
            border-color: #f1f5f9 !important;
        }

        .handsontable .htAutocompleteArrow {
            color: #94a3b8;
        }
    </style>
@endpush

@section('content')

    <div class="max-w-6xl mx-auto px-1 pb-24 lg:pb-8">
        {{-- Header --}}
        <header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('master.heat-numbers.index') }}"
                        class="text-slate-400 hover:text-primary transition-colors">
                        <span class="material-icons text-xl">arrow_back</span>
                    </a>
                    <h1 class="text-2xl font-bold tracking-tight">Bulk Import Heat Numbers</h1>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 ml-8">Paste your data directly from Excel or CSV files
                </p>
            </div>

            <div class="flex gap-2 ml-8 md:ml-0">
                <button id="saveBtn"
                    class="h-12 px-6 rounded-2xl bg-primary text-white shadow-lg shadow-primary/20 flex items-center gap-2 font-bold active:scale-95 transition-all">
                    <span class="material-icons text-lg">cloud_upload</span>
                    Save Records
                </button>
            </div>
        </header>

        {{-- Info Card --}}
        <div
            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 rounded-2xl p-4 mb-6 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex-shrink-0 flex items-center justify-center">
                <span class="material-icons text-lg">info</span>
            </div>
            <div>
                <h4 class="font-bold text-blue-900 dark:text-blue-200 text-sm">Quick Instructions</h4>
                <p class="text-xs text-blue-700 dark:text-blue-300 mt-0.5">Copy your Excel range and paste it inside the
                    grid below. Ensure the <strong class="underline">Heat Number</strong> and <strong class="underline">Item
                        Code</strong> columns are filled for each row.</p>
            </div>
        </div>

        {{-- Grid Container --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-6">
            <div class="p-2">
                <div id="grid-container" style="width: 100%; height: 500px;" class="overflow-hidden rounded-2xl"></div>
            </div>
        </div>

        {{-- Error Log --}}
        <div id="errorLog" style="display: none;" class="animate-in fade-in slide-in-from-top-4 duration-300">
            <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800/50 rounded-2xl p-5">
                <div class="flex items-center gap-3 text-rose-600 mb-3 font-bold">
                    <span class="material-icons">report_problem</span>
                    Some records failed to import
                </div>
                <ul id="errorList" class="space-y-1 ml-9 list-disc text-sm text-rose-600/80 dark:text-rose-400"></ul>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const container = document.getElementById('grid-container');
        const saveBtn = document.getElementById('saveBtn');

        // Initial 30 Empty Rows
        const data = Array.from({ length: 30 }, () => ['', '', '', '']);

        const hot = new Handsontable(container, {
            data: data,
            rowHeaders: true,
            colHeaders: ['HEAT NUMBER', 'ITEM CODE', 'COR QTY', 'KODE PRODUKSI'],
            height: '100%',
            width: '100%',
            licenseKey: 'non-commercial-and-evaluation',
            stretchH: 'all',
            columns: [
                { data: 0, placeholder: 'e.g. HN-2024-X' }, // Heat Number
                { data: 1, placeholder: 'e.g. 1.002.3' }, // Item Code
                { data: 2, type: 'numeric' }, // Cor Qty
                { data: 3 }, // Kode Produksi
            ],
            contextMenu: true,
            autoWrapRow: true,
            autoWrapCol: true,
            minSpareRows: 5,
        });

        saveBtn.addEventListener('click', async () => {
            const tableData = hot.getData();
            const payload = [];

            // Clean and prepare data
            tableData.forEach(row => {
                if (row[0] && row[1]) { // If Heat Number and Item Code are not empty
                    payload.push({
                        heat_number: row[0],
                        item_code: row[1],
                        cor_qty: row[2],
                        kode_produksi: row[3]
                    });
                }
            });

            if (payload.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'No Data Found',
                    text: 'Please paste or enter valid data into the grid first.',
                    confirmButtonColor: '#2563EB'
                });
                return;
            }

            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="material-icons text-lg animate-spin">sync</span> Saving...';

            try {
                const response = await fetch('{{ route("master.heat-numbers.bulk-store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ data: payload })
                });

                const result = await response.json();

                if (result.success) {
                    if (result.errors && result.errors.length > 0) {
                        // Partly Success
                        Swal.fire({
                            icon: 'warning',
                            title: 'Partial Import',
                            text: result.message + ' some rows had issues.',
                            confirmButtonColor: '#2563EB'
                        });

                        document.getElementById('errorLog').style.display = 'block';
                        const errorList = document.getElementById('errorList');
                        errorList.innerHTML = '';
                        result.errors.forEach(err => {
                            const li = document.createElement('li');
                            li.textContent = err;
                            errorList.appendChild(li);
                        });
                    } else {
                        // All Success
                        Swal.fire({
                            icon: 'success',
                            title: 'Import Successful',
                            text: result.message,
                            confirmButtonColor: '#2563EB'
                        }).then(() => {
                            window.location.href = '{{ route("master.heat-numbers.index") }}';
                        });
                    }
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'Unable to process import at this time.',
                    confirmButtonColor: '#2563EB'
                });
            } finally {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<span class="material-icons text-lg">cloud_upload</span> Save Records';
            }
        });
    </script>
@endpush