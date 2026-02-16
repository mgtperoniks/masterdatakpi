<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdDepartment;
use Illuminate\Http\Request;

class MasterCategoryController extends Controller
{
    /**
     * Categories requested:
     * 1. Flange SS (400.1)
     * 2. Fitting SS (400.2)
     * 3. Aluminium (400.3)
     * 4. Flange Besi (400.4)
     */
    protected $targetDepts = ['400.1', '400.2', '400.3', '400.4'];

    public function selectItems()
    {
        $departments = MdDepartment::whereIn('code', $this->targetDepts)
            ->orderBy('code')
            ->get()
            ->map(function ($dept) {
                $dept->icon = $this->getIcon($dept->code);
                return $dept;
            });

        return view('master.selection', [
            'departments' => $departments,
            'title' => 'Pilih Kategori Item',
            'type' => 'items'
        ]);
    }

    public function selectHeatNumbers()
    {
        $departments = MdDepartment::whereIn('code', $this->targetDepts)
            ->orderBy('code')
            ->get()
            ->map(function ($dept) {
                $dept->icon = $this->getIcon($dept->code);
                return $dept;
            });

        return view('master.selection', [
            'departments' => $departments,
            'title' => 'Pilih Kategori Heat Number',
            'type' => 'heat-numbers'
        ]);
    }

    private function getIcon($code)
    {
        return match ($code) {
            '400.1' => 'trip_origin',    // Flange SS - Lingkaran
            '400.2' => 'architecture',   // Fitting SS - Konstruksi
            '400.3' => 'layers',         // Aluminium - Lembaran/Layer
            '400.4' => 'settings_suggest', // Flange Besi - Komponen
            default => 'inventory_2',
        };
    }
}
