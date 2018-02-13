<?php

namespace App\Models;

use App\Traits\AttendanceTrait;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use AttendanceTrait;
    protected $fillable = ['att_token','should','real','class_id','creator_id','status'];
}
