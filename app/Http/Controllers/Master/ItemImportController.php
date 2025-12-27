<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdItem;
use App\Models\MdDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $rows = array_map('str_getcsv', file($request->file));
        $header = array_map('trim', array_shift($rows));

        $required = ['code','name','department_code','cycle_time_sec','status'];

        if ($header !== $required) {
            return back()->withErrors('Format CSV tidak sesuai template.');
        }

        $inserted = 0;
        $errors = [];

        foreach ($rows as $i => $row) {
            $data = array_combine($header, $row);

            try {
                // basic validation
                if (
                    empty($data['code']) ||
                    empty($data['name']) ||
                    !MdDepartment::where('code',$data['department_code'])->exists() ||
                    (int)$data['cycle_time_sec'] <= 0 ||
                    !in_array($data['status'], ['active','inactive'])
                ) {
                    throw new \Exception('Invalid data');
                }

                // skip if exists
                if (MdItem::where('code',$data['code'])->exists()) {
                    continue;
                }

                MdItem::create([
                    'code' => $data['code'],
                    'name' => $data['name'],
                    'department_code' => $data['department_code'],
                    'cycle_time_sec' => (int)$data['cycle_time_sec'],
                    'status' => $data['status'],
                ]);

                $inserted++;

            } catch (\Throwable $e) {
                $errors[] = 'Row '.($i+2).' gagal';
            }
        }

        return redirect()
            ->route('master.items.index')
            ->with('success', "Import selesai. {$inserted} item berhasil.")
            ->with('import_errors', $errors);
    }
}
