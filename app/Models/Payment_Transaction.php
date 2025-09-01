<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_Transaction extends Model
{
    protected $fillable = ['payment_date','payment_time','payment_status','job_request_id','amount_paid','amount_deficit','mode_of_payment' , 'delete_status', 'remark'];
}
