<?php

namespace App\Traits;

use App\Models\MdAuditLog;

trait Auditable
{
    protected function audit(
        string $table,
        string $recordCode,
        string $action,
        string $source = 'master',
        ?string $description = null
    ): void {
        $log = new MdAuditLog();
        $log->table_name  = $table;
        $log->record_code = $recordCode;
        $log->action      = $action;
        $log->source      = $source;
        $log->description = $description;
        $log->created_at  = now();
        $log->save();
    }
}
