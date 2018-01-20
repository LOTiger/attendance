<?php

namespace App\Models;

use App\Traits\TeacherTrait;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use TeacherTrait;
    protected $fillable = ['id','user_id','spe_id'];
}
