<?php

namespace App\Http\Controllers;
use App\Models\{Job_Request, Job_Assignment};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class ClientController extends Controller
{


    public function track(){
    	$check = 0;
    	return view('client.welcome', compact('check'));
    }

    public function trackedResult(Request $request){
    	$check = 0;
		$Job_Request = Job_Request::where('reference_number', $request->input('job_tracking'))->first();

    	if(is_null($Job_Request)){
    		$check = 1;
    		return view('client.welcome', compact('check'));
    	}else{
    		$employees = Job_Assignment::where('job_request_id', $Job_Request->job_request_id)->get();

	    	$s = DB::table('job__task__completions')->where('job_request_id',$Job_Request->job_request_id)->where('delete_status', 'NOT DELETED')->orderBy('created_at','desc')->first();

	    	$current_task = DB::table('tasks')->where('task_id', $s->task_id + 1)->first();

	    	$start_date = DB::table('job__task__completions')->where('job_request_id',$Job_Request->job_request_id)->where('delete_status', 'NOT DELETED')->orderBy('created_at','asc')->first();

        $tasks = DB::table('tasks')->where('job_id',$Job_Request->job_id)->where('delete_status', 'NOT DELETED')->get();


            return view('client.tracked-result',compact('current_task', 'start_date','Job_Request', 's', 'employees', 'tasks'));
    	}
    }
}
