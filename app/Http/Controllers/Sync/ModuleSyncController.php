<?php

namespace App\Http\Controllers\Sync;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MdMachine;
use App\Traits\Auditable;

class ModuleSyncController extends Controller
{
    use Auditable;

    public function syncMachines(Request $request)
    {
        $request->validate([
            'module' => 'required|string|max:50',
            'machines' => 'required|array',
            'machines.*.code' => 'required|string|exists:md_machines,code',
            'machines.*.last_seen_at' => 'nullable|date',
        ]);

        $module = $request->module;

        foreach ($request->machines as $item) {
            $machine = MdMachine::where('code', $item['code'])->first();

            // update metadata saja
            $machine->update([
                'last_seen_at' => $item['last_seen_at'] ?? now(),
                'last_active_module' => $module,
                'last_sync_at' => now(),
            ]);

            // audit sync
            $this->audit(
                'md_machines',
                $machine->code,
                'sync',
                'module',
                "Sync from {$module}"
            );
        }

        return response()->json([
            'status' => 'ok',
            'synced' => count($request->machines),
        ]);
    }
}
