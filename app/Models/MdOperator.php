<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdOperator extends Model
{
    protected $table = 'md_operators';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'code',
        'name',
        'department_code',
        'position',
        'gender',
        'employment_type',
        'join_date',
        'employment_seq',
        'status',
        'active_from',
        'active_until',
        'inactive_at',
        'inactive_reason',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'join_date'    => 'date',
        'active_from'  => 'date',
        'active_until' => 'date',
        'inactive_at'  => 'date',
    ];

    /* =========================
       RELATIONSHIPS
    ========================= */

    public function department()
    {
        return $this->belongsTo(
            MdDepartment::class,
            'department_code',
            'code'
        );
    }

    /* =========================
       SCOPES
    ========================= */

    /**
     * Scope active operators
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope inactive operators
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope operators currently active by date
     */
    public function scopeCurrentlyActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->whereDate('active_from', '<=', now())
            ->where(function ($q) {
                $q->whereNull('active_until')
                  ->orWhereDate('active_until', '>=', now());
            });
    }

    /* =========================
       HELPERS
    ========================= */

    /**
     * Check operator active status
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Display operator code with employment sequence
     * Example: OP001#2
     */
    public function displayCode(): string
    {
        return "{$this->code}#{$this->employment_seq}";
    }
}
