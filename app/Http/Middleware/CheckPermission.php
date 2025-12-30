<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Permission;

class CheckPermission
{
    public function handle($request, Closure $next, $action, $module)
    {
        $allowed = match ($action) {
            'view' => Permission::canView($module),
            'manage' => Permission::canManage($module),
            'audit' => Permission::canAudit(),
            'recycle' => Permission::canRecycle(),
            default => false,
        };

        if (!$allowed) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
