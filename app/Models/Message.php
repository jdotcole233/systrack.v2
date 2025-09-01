<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message_id','job_request_id' , 'delete_status', 'message', 'emp_id', 'time'];
}
