<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['location_ip_addresses','emp_id', 'longitude', 'latitude', 'region_name', 'city_name' , 'country_code', 'user_agent' ,'delete_status'];
}
