<?php

namespace App\Models;

use App\Traits\DepartmentTrait;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use DepartmentTrait;
    protected $fillable = [
        'depar_name', 'desc',
    ];

    protected $hidden = [
        'created_at','updated_at'
    ];
}
