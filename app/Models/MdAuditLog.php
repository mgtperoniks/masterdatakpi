<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdAuditLog extends Model
{
    protected $table = 'md_audit_logs';

    public $timestamps = false;

    protected $fillable = [
        'table_name',
        'record_code',
        'action',
        'source',
        'description',
        'created_at',
    ];
}
