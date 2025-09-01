<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_Client extends Model
{
    protected $fillable = ['emp_id','client_id', 'delete_status'];
}
