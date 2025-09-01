<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['notification_id', 'message','subject', 'sender_id', 'reciever_id' , 'delete_status', 'notification_time'];
}
