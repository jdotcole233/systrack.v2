<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_Meeting extends Model
{
    protected $fillable = ['emp_id','meeting_id' , 'delete_status'];
}
