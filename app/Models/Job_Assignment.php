<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job_Assignment extends Model
{
    protected $fillable = ['emp_id','job_request_id','assignment_status' , 'delete_status', 'assigned_by'];
}
