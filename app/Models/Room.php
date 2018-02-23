<?php

namespace App\Models;

use App\Traits\RoomTrait;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use RoomTrait;
    protected $fillable = ['room_name','build_id'];
    protected $hidden = [
        'created_at','updated_at'
    ];
}
