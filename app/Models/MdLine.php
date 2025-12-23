<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdLine extends Model
{
    protected $table = 'md_lines';

    protected $fillable = [
        'code',
        'department_code',
        'name',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(MdDepartment::class, 'department_code', 'code');
    }

    public function machines()
    {
        return $this->hasMany(MdMachine::class, 'line_code', 'code');
    }
}
