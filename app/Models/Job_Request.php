<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job_Request extends Model
{
    protected $fillable = ['client_id','job_id','status','job_priority','reference_number', 'details', 'job_cost' , 'delete_status', 'created_by'];
}
