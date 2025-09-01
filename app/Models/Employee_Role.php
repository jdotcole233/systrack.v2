<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_Role extends Model
{
    protected $fillable = ['emp_id','position','employment_date' , 'delete_status'];
}
