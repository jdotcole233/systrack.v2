<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mgr_Emp_Interact extends Model
{
    protected $fillable = ['manager_id','emp_id','message','response' , 'delete_status'];
}
