<?php

namespace App\Models;


use App\Traits\LessonTrait;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use LessonTrait;
    protected $fillable = [
        'name', 'section', 'week_begin',
        'week_end', 'weekday', 'room_id', 'class_id',
        'status', 'teacher_id', 'is_single'
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
