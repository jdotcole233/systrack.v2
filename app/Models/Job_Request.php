<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Job_Request extends Model
{
    protected $fillable = ['client_id', 'job_id', 'status', 'job_priority', 'reference_number', 'details', 'job_cost', 'delete_status', 'created_by'];

    public function job(): HasOne
    {
        return $this->hasOne(Job::class, 'job_id', 'job_id');
    }
}
