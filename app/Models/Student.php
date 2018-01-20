<?php

namespace App\Models;

use App\Traits\StudentTrait;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use StudentTrait;
    protected $fillable = ['id','user_id','class_id'];

}
