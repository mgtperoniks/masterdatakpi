<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Permission
{
    protected static function user()
    {
        return Auth::user();
    }

    public static function canView(string $module): bool
    {
        $u = self::user();
        if (!$u) return false;

        // Direktur, MR, Auditor bisa lihat semua
        if (in_array($u->role, ['direktur', 'MR', 'auditor'])) {
            return true;
        }

        // HR scope
        if ($u->scope === 'HR') {
            return in_array($module, ['operators']);
        }

        // PPIC scope
        if ($u->scope === 'PPIC') {
            return in_array($module, ['lines', 'machines', 'items']);
        }

        return false;
    }

    public static function canManage(string $module): bool
    {
        $u = self::user();
        if (!$u) return false;

        // Direktur & MR full access
        if (in_array($u->role, ['direktur', 'MR'])) {
            return true;
        }

        // Auditor never manage
        if ($u->role === 'auditor') {
            return false;
        }

        // Manager
        if ($u->role === 'manager') {
            if ($u->scope === 'HR') {
                return $module === 'operators';
            }
            if ($u->scope === 'PPIC') {
                return in_array($module, ['lines', 'machines', 'items']);
            }
        }

        // Admin: create only (UI level, controller still protect)
        if ($u->role === 'admin') {
            if ($u->scope === 'HR') {
                return $module === 'operators';
            }
            if ($u->scope === 'PPIC') {
                return in_array($module, ['lines', 'machines', 'items']);
            }
        }

        return false;
    }

    public static function canAudit(): bool
    {
        $u = self::user();
        return $u && in_array($u->role, ['direktur', 'MR', 'auditor']);
    }

    public static function canRecycle(): bool
    {
        $u = self::user();
        return $u && in_array($u->role, ['direktur', 'MR']);
    }
}
