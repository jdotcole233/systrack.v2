<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_Address extends Model
{
    protected $fillable = ['street','suburb','region','country','emp_id', 'delete_status'];
}
