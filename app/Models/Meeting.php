<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['title','purpose','date','minutes','meeting_venue','meeting_start_time','meeting_end_time','meeting_status' , 'delete_status'];
}
