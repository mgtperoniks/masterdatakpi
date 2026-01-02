<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MdItem extends Model
{
    use SoftDeletes;

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

    /**
     * Explicit date fields for SoftDeletes
     */
    protected $dates = [
        'deleted_at',
    ];

    protected $casts = [
        'cycle_time_sec' => 'integer',
        'unit_weight'    => 'decimal:3',
        'last_sync_at'   => 'datetime',
        'deleted_at'     => 'datetime',
    ];

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
