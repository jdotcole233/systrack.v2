<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emp_Client_Interact extends Model
{
    protected $fillable = ['message','response','message_status','client_id','emp_id', 'delete_status'];
}
