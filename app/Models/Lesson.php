<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'name', 'section', 'week_begin',
        'week_end', 'weekday', 'room_id', 'class_id',
        'status', 'teacher_work_num', 'is_single'
    ];
}
