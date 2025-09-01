<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['contact_name','organization','position','contact_number','address','email','contact_remarks','website' , 'delete_status'];
}
