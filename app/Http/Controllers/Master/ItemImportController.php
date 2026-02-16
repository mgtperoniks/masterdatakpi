<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdItem;
use App\Models\MdDepartment;
use Illuminate\Http\Request;

class ItemImportController extends Controller
{
    public function form()
    {
        return view('master.items.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $rows = array_map('str_getcsv', file($request->file->getRealPath()));

        if (count($rows) < 2) {
            return redirect()
                ->route('master.items.index')
                ->with('error', 'File CSV kosong');
        }

        $header = array_map(
            fn($h) => strtolower(trim($h)),
            array_shift($rows)
        );

        $required = [
            'code',
            'name',
            'aisi',
            'standard',
            'unit_weight',
            'department_code',
            'cycle_time_sec',
            'status',
        ];

        foreach ($required as $col) {
            if (!in_array($col, $header, true)) {
                return redirect()
                    ->route('master.items.index')
                    ->with('error', "Kolom CSV wajib tidak ditemukan: {$col}");
            }
        }

        $inserted = 0;
        $errors = [];

        foreach ($rows as $i => $row) {

            if (count($row) !== count($header)) {
                $errors[] = "Row " . ($i + 2) . " jumlah kolom tidak sesuai";
                continue;
            }

            $data = array_combine($header, $row);
            $data = array_map(fn($v) => is_string($v) ? trim($v) : $v, $data);

            $code = $data['code'] ?? '';
            $name = $data['name'] ?? '';
            $dept = $data['department_code'] ?? '';
            $status = strtolower($data['status'] ?? '');

            if ($code === '' || $name === '') {
                $errors[] = "Row " . ($i + 2) . " code / name kosong";
                continue;
            }

            if (!MdDepartment::where('code', $dept)->exists()) {
                $errors[] = "Row " . ($i + 2) . " department_code tidak valid";
                continue;
            }

            if ((int) $data['cycle_time_sec'] <= 0) {
                $errors[] = "Row " . ($i + 2) . " cycle_time_sec tidak valid";
                continue;
            }

            if (!in_array($status, ['active', 'inactive'], true)) {
                $errors[] = "Row " . ($i + 2) . " status harus active / inactive";
                continue;
            }

            if (
                MdItem::where('code', $code)
                    ->where('status', 'active')
                    ->exists()
            ) {
                $errors[] = "Row " . ($i + 2) . " dilewati (code aktif sudah ada)";
                continue;
            }

            MdItem::create([
                'code' => $code,
                'name' => $name,
                'aisi' => $data['aisi'] ?? '',
                'standard' => $data['standard'] ?? '',
                'unit_weight' => is_numeric($data['unit_weight'])
                    ? (float) $data['unit_weight']
                    : null,
                'department_code' => $dept,
                'cycle_time_sec' => (int) $data['cycle_time_sec'],
                'status' => $status,
            ]);

            $inserted++;
        }

        return redirect()
            ->route('master.items.index')
            ->with('success', "Import selesai. {$inserted} item berhasil ditambahkan.")
            ->with('import_errors', $errors);
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
        ]);

        $rows = $request->data;
        $inserted = 0;
        $errors = [];

        foreach ($rows as $i => $row) {
            $code = trim($row['code'] ?? '');
            $name = trim($row['name'] ?? '');
            $aisi = trim($row['aisi'] ?? '');
            $standard = trim($row['standard'] ?? '');
            $unitWeight = $row['unit_weight'] ?? null;
            $dept = trim($row['department_code'] ?? '');
            $cycleTime = (int) ($row['cycle_time_sec'] ?? 0);
            $status = strtolower(trim($row['status'] ?? 'active'));

            if ($code === '' || $name === '') {
                $errors[] = "Row " . ($i + 1) . ": Code or Name is empty.";
                continue;
            }

            if (!MdDepartment::where('code', $dept)->exists()) {
                $errors[] = "Row " . ($i + 1) . ": Invalid Department Code ({$dept}).";
                continue;
            }

            if ($cycleTime <= 0) {
                $errors[] = "Row " . ($i + 1) . ": Cycle time must be positive.";
                continue;
            }

            if (!in_array($status, ['active', 'inactive'])) {
                $errors[] = "Row " . ($i + 1) . ": Status must be 'active' or 'inactive'.";
                continue;
            }

            // check duplicate if active
            if ($status === 'active' && MdItem::where('code', $code)->where('status', 'active')->exists()) {
                $errors[] = "Row " . ($i + 1) . ": Active item with code {$code} already exists.";
                continue;
            }

            try {
                MdItem::updateOrCreate(
                    ['code' => $code, 'status' => $status],
                    [
                        'name' => $name,
                        'aisi' => $aisi,
                        'standard' => $standard,
                        'unit_weight' => is_numeric($unitWeight) ? (float) $unitWeight : null,
                        'department_code' => $dept,
                        'cycle_time_sec' => $cycleTime
                    ]
                );
                $inserted++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($i + 1) . ": Database error - " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Import processed. {$inserted} items saved.",
            'errors' => $errors
        ]);
    }
}
