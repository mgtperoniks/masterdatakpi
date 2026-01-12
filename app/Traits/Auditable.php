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
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {
        MdAuditLog::create([
            'user_id' => auth()->id(),
            'table_name' => $table,
            'record_code' => $recordCode,
            'action' => $action,
            'source' => $source,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'created_at' => now(),
        ]);
    }
}
