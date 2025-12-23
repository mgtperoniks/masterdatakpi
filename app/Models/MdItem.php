<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdItem extends Model
{
    protected $table = 'md_items';

    protected $fillable = [
        'code',
        'name',
        'department_code',
        'cycle_time_sec',
        'status',
        'last_sync_at',
    ];

    protected $casts = [
        'cycle_time_sec' => 'integer',
        'last_sync_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(MdDepartment::class, 'department_code', 'code');
    }
}
