<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MdAuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAudit();
        $query = MdAuditLog::with('user');

        if ($request->table_name) {
            $query->where('table_name', $request->table_name);
        }

        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->orderByDesc('created_at')->limit(200)->get();

        $tables = MdAuditLog::select('table_name')->distinct()->pluck('table_name');

        return view('master.audit_logs.index', compact('logs', 'tables'));
    }

    protected function authorizeAudit()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['direktur', 'mr'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
