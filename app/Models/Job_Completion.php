<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job_Completion extends Model
{
    protected $fillable = ['job_assignment_id','comments','start_date','end_date','job_request_id' , 'delete_status'];
}
