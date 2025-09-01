<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['first_name','other_name','last_name','gender','contact_number','position','address','company_email', 'delete_status', 'profile_pic'];
}
