<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting_Attend extends Model
{
    protected $fillable = ['meeting_id','attendant_name' , 'delete_status'];
}
