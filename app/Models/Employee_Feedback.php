<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_Feedback extends Model
{
    protected $fillable = ['emp_id','feedback','date','time' , 'delete_status'];
}
