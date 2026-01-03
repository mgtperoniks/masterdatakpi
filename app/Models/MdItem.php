<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdItem extends Model
{
    protected $table = 'md_items';

    protected $fillable = [
        'code',
        'name',
        'aisi',
        'standard',
        'unit_weight',
        'department_code',
        'cycle_time_sec',
        'status',
        'last_sync_at',
    ];

    protected $casts = [
        'cycle_time_sec' => 'integer',
        'unit_weight'    => 'decimal:3',
        'last_sync_at'   => 'datetime',
    ];

    /**
     * Scope: hanya item aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Relation: Department
     */
    public function department()
    {
        return $this->belongsTo(
            MdDepartment::class,
            'department_code',
            'code'
        );
    }
}
