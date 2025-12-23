<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MdMachine extends Model
{
    protected $table = 'md_machines';

    protected $fillable = [
        'code',
        'name',
        'department_code',
        'line_code',
        'status', // status DB (active / inactive)
        'last_seen_at',
        'last_active_module',
        'last_sync_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'last_sync_at' => 'datetime',
    ];

    protected $appends = [
        'computed_status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function department()
    {
        return $this->belongsTo(MdDepartment::class, 'department_code', 'code');
    }

    public function line()
    {
        return $this->belongsTo(MdLine::class, 'line_code', 'code');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getComputedStatusAttribute(): string
    {
        if (empty($this->last_seen_at)) {
            return 'OFFLINE';
        }

        $minutes = Carbon::parse($this->last_seen_at)->diffInMinutes(now());

        if ($minutes <= 2) {
            return 'ONLINE';
        }

        if ($minutes <= 10) {
            return 'STALE';
        }

        return 'OFFLINE';
    }
}
