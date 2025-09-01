<?php

namespace App\Http\Controllers;

use App\Models\{Job_Assignment, Job_Task_Completion, Job_Completion, Activity, Contact, Job_Request, Task, Client};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Response};
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('employee');
    }

    public function employeeJobs($user) {
        $my_jobs = Job_Assignment::where('emp_id', Auth::user()->emp_id)->where('delete_status', 'NOT DELETED')->get();
        return view('employee.jobs', compact('my_jobs', 'user'));
    }

    public function employeeIndex(){
        return view('employee.home');
    }

    public function employeeReports(){
        return view('employee.reports');
    }


    public function save_job_task(Request $request) {

        $start_date = DB::table('job__task__completions')->where('job_request_id',$request->input('job_request_id'))->where('delete_status', 'NOT DELETED')->where('status', 'completed')->orderBy('created_at','desc')->value('end_date');

        $job_task = Job_Task_Completion::create($request->all());

        Job_Task_Completion::where('job_task_completion_id', $job_task->id)->update(['start_date' => $start_date]);
        if ($request->input('status') == "completed") {
            Job_Task_Completion::where('job_task_completion_id', $job_task->id)->update(['end_date' => $job_task->created_at]);
        }

        $completed = DB::table('job__task__completions')->where('job_request_id',$request->input('job_request_id'))->where('delete_status', 'NOT DELETED')->where('status', 'completed')->orderBy('created_at','desc')->value('task_id');

        $job_request = Job_Request::where('job_request_id',$request->input('job_request_id'))->first();

        $last = Task::where('task_id', $completed + 1)->where('job_id',$job_request->job_id)->first();
        if($last == null) {
            $start_date = DB::table('job__task__completions')->where('job_request_id',$request->input('job_request_id'))->where('delete_status', 'NOT DELETED')->where('status', 'completed')->orderBy('created_at','asc')->value('end_date');
            $job = Job_Completion::create($request->all());
            Job_Completion::where('job_completion_id', $job->id)->update(['end_date' => $job->created_at, 'start_date' => $start_date]);
            Job_Request::where('job_request_id',$request->input('job_request_id'))->update(['renewal_date' => $request->input('renewal_date')]);
        }
        return response()->json(['success'=>$start_date]);
    }


    public function getStats () {
        $assigned_jobs = Job_Assignment::where('emp_id', Auth::user()->emp_id)->where('delete_status', 'NOT DELETED')->count();
        // Job_Request::all()->count();
        $completed_jobs = DB::table('job__completions')->join('job__assignments', 'job__completions.job_request_id','job__assignments.job_request_id')->where('job__assignments.emp_id', Auth::user()->emp_id)->count();
        $unassigned_jobs = Job_Assignment::where('emp_id', Auth::user()->emp_id)->where('delete_status', 'DELETED')->count();
        $pending_jobs = DB::table('job__assignments')->leftJoin('job__completions','job__assignments.job_request_id', 'job__completions.job_request_id')->where('job__assignments.emp_id', Auth::user()->emp_id)->count();
        $contacts = Contact::all()->count();
        $activities = Activity::where('emp_id', Auth::user()->emp_id)->count();
        return response()->json([
            'assigned_jobs' => $assigned_jobs,
            'completed_jobs' => $completed_jobs,
            'unassigned_jobs' => $unassigned_jobs,
            'pending_jobs' => $pending_jobs,
            'contacts' => $contacts,
            'activities' => $activities
        ]);

    }

    public function employeeClients($user){
		$client_info = DB::table('clients')->select('*')->where('delete_status', 'NOT DELETED')->get();
          $current_date = Carbon::now();
          $last_month = Carbon::now()->subDays(30);
          $new_client_information = Client::whereBetween('created_at',[$last_month->toDateTimeString(), $current_date->toDateTimeString()])->where('delete_status', 'NOT DELETED')->get();
		  Response::json($new_client_information);
    	return  view('employee.clients',compact('client_info','new_client_information', 'user'));
    }

    public function  firmus_client_send(Request $request){
      $back_infor = Client::create($request->except('_token'));

      return response()->json(["successful"=>"Client Added Successfully","Data_back"=>$back_infor]);
    }


    public function firmus_client_edit($id){
        	//Client::where('client_id',$id)->update($request->except('_token'));
        	$client_e_info = DB::table('clients')->select('*')->where('client_id',$id)->where('delete_status', 'NOT DELETED')->first();

        	return  response()->json($client_e_info);
        }

    public function firmus_client_real_edit(Request $request,$id){
           $editted_detail = Client::where('client_id',$id)->where('delete_status', 'NOT DELETED')->update($request->except('_token'));

           return  response()->json(['message'=>'Client Detail updated successfully','datails'=>$editted_detail]);
         }


    public function firmus_client_delete($id){
         	$delete_detail = DB::table('clients')->where('client_id',$id)->update(['delete_status' => 'DELETED']);


         	return response()->json($delete_detail);

         }

}
