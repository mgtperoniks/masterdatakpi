<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdDepartment extends Model
{
    protected $table = 'md_departments';

    protected $fillable = [
        'code',
        'name',
        'status',
    ];

    public function lines()
    {
        return $this->hasMany(MdLine::class, 'department_code', 'code');
    }

    public function machines()
    {
        return $this->hasMany(MdMachine::class, 'department_code', 'code');
    }

    public function operators()
    {
        return $this->hasMany(MdOperator::class, 'department_code', 'code');
    }

    public function items()
    {
        return $this->hasMany(MdItem::class, 'department_code', 'code');
    }
}
