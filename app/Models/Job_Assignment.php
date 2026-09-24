<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job_Assignment extends Model
{
    protected $fillable = ['emp_id','job_request_id','assignment_status' , 'delete_status', 'assigned_by'];


    public function job_request(): BelongsTo
    {
        return $this->belongsTo(Job_Request::class, 'job_request_id', 'job_request_id');
    }
}
