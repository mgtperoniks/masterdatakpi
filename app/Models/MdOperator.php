<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdOperator extends Model
{
    protected $table = 'md_operators';

    protected $fillable = [
        'code',
        'name',
        'department_code',
        'status',
        'last_seen_at',
        'last_active_module',
        'last_sync_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'last_sync_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(MdDepartment::class, 'department_code', 'code');
    }
}
