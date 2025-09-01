<?php

namespace App\Http\Controllers;

use App\Models\{Message};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Response, View};

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function message (Request $request) {
        Message::create(['job_request_id' => $request->input('job_request_id'), 'emp_id' => Auth::user()->emp_id, 'message' => $request->input('message'), 'message_time' => date("h:i:s")]);
        return response()->json(['message' => 'success']);
    }

    public function getMessages ($id) {
        $messages = Message::all()->where('job_request_id',$id);
        return Response::json(View::make('messages.messages', array('messages' => $messages))->render());
    }
}
