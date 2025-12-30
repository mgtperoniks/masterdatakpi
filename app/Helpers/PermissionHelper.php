<?php

namespace App\Helpers;

class PermissionHelper
{
    protected static function role(): string
    {
        $user = auth()->user();
        if (!$user) return '';

        return strtolower(
            trim(
                str_replace([' ', '-'], '_', $user->role)
            )
        );
    }

    public static function canView(string $module): bool
    {
        $role = self::role();

        // Direktur & MR
        if (in_array($role, ['direktur', 'mr'])) {
            return true;
        }

        // Auditor: read-only semua
        if ($role === 'auditor') {
            return true;
        }

        // HR scope
        if (in_array($role, ['manager_hr', 'admin_hr'])) {
            return $module === 'operators';
        }

        // PPIC scope
        if (in_array($role, ['manager_ppic', 'admin_ppic'])) {
            return in_array($module, ['lines', 'machines', 'items']);
        }

        return false;
    }

    public static function canManage(string $module): bool
    {
        $role = self::role();

        // Direktur & MR
        if (in_array($role, ['direktur', 'mr'])) {
            return true;
        }

        // Manager boleh manage
        if (str_starts_with($role, 'manager_')) {
            return true;
        }

        // Admin tidak boleh edit/hapus
        return false;
    }

    public static function canSeeAudit(): bool
    {
        $role = self::role();

        return in_array($role, ['direktur', 'mr', 'auditor']);
    }
}
