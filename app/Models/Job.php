<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'firmus_jobs';
    protected $fillable = ['job_name','details' , 'delete_status'];
}
