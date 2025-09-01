<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job_Task_Completion extends Model
{
    protected $fillable = ['job_assignment_id', 'job_request_id' ,'task_id','status','comments','start_date','end_time' , 'delete_status'];
}
