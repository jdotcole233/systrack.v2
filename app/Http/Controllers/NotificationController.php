<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Notification, Employee, Activity};
use Illuminate\Support\Facades\{Auth, Response, View};


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getNotification () {
    	$notifications = Notification::where('reciever_id', Auth::user()->emp_id)->where('delete_status' , '<>' ,'DELETED')->get();
    	return Response::json(View::make('notifications.messages', array('notifications' => $notifications))->render());
    }

    public function sendnotification (Request $request) {
    	$recievers = Employee::where($request->input('check'), $request->input('condition'), $request->input('reciever'))->get();
    	
    	foreach ($recievers as $reciever) {
    		Notification::create(['subject' => $request->input('subject'), 'sender_id' => Auth::user()->emp_id, 'message' => $request->input('message'), 'notification_time' => date("h:i:s"), 'reciever_id' => $reciever->emp_id]);
    	}
    	
       	return response()->json(['message' => 'success']);
    }

    public function deleteNotification ($notification_id) {
    	Notification::where('notification_id', $notification_id)->update('delete_status', 'DELETED');
    	return response()->json(['message' => 'success']);
    }
    
     public function deleteNotificationEmployee ($notification_id) {
    	Notification::where('notification_id', $notification_id)->update(['delete_status' => 'DELETED']);
    	return response()->json(['message' => 'success']);
    }

    public function deleteAllNotificationEmployee () {
    	Notification::where('reciever_id', Auth::user()->emp_id)->update(['delete_status' => 'DELETED']);
    	return response()->json(['message' => 'success']);
    }

    public function countNotification () {   
        $count = Notification::where('reciever_id', Auth::user()->emp_id)->where('delete_status' , '<>' ,'DELETED')->count();
        return response()->json(['count' => $count]);
    }
}
