<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdAuditLog extends Model
{
    protected $table = 'md_audit_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'table_name',
        'record_code',
        'action',
        'source',
        'ip_address',
        'user_agent',
        'description',
        'old_values',
        'new_values',
        'created_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
