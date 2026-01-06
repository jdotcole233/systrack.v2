<?php

namespace App\Http\Controllers;

use App\Models\{Employee, Job_Assignment, Job_Task_Completion, Job_Request, Client, Job, Payment_Transaction};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth, Response, View};

class ManagerAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('manager');
    }

    public function viewJobRequests($user)
    {
        $job_requests = Job_Request::join('firmus_jobs', 'job__requests.job_id', 'firmus_jobs.job_id')
        ->where('firmus_jobs.delete_status', 'NOT DELETED')
        ->where('job__requests.delete_status', 'NOT DELETED')
        ->select('job__requests.*')
        ->latest('created_at')
        ->get();
        // dd($job_requests);
        $clients = Client::all()->where('delete_status', 'NOT DELETED');
        $jobs = Job::all()->where('delete_status', 'NOT DELETED');
        $employees = Employee::where('position', '<>', 'Accountant')->where('delete_status', 'NOT DELETED')->get();
        return view('manager.jobs', compact('jobs', 'clients', 'job_requests', 'employees', 'user'));
    }

    //    public function viewJobAssignments () {
//        $jobs = Job_Assignment::all();
//        return view('manager.jobs', 'jobs');
//    }

    public function addJobRequest(Request $request)
    {
        $new_job_added = Job_Request::create($request->all());
        $job_name = DB::table('firmus_jobs')->select('job_name')
            ->where('job_id', $new_job_added->job_id)
            ->where('delete_status', 'NOT DELETED')
            ->first()
            ->job_name;

        Job_Request::where('job_request_id', $new_job_added->id)
            ->update([
                'created_by' => Auth::user()->emp_id,
                'renewal_status' => 'NOT RENEWED'
            ]);

        $client_name = DB::table('clients')
            ->select('company_name')
            ->where('client_id', $new_job_added->client_id)
            ->where('delete_status', 'NOT DELETED')
            ->first()
            ->company_name;
            
        return response()->json(['message' => 'success', 'Data_back' => $new_job_added, 'client_info' => $client_name]);
    }

    public function editJobRequest(Request $request)
    {
        Job_Request::where('job_request_id', $request->input('job_request_id'))->update($request->except('job_request_id', '_token'));
        return response()->json(['message' => 'success']);
    }

    public function deleteJobRequest(Request $request)
    {
        Job_Request::where('job_request_id', $request->input('job_request_id'))->update(['delete_status' => 'DELETED']);
        Job_Assignment::where('job_request_id', $request->input('job_request_id'))->update(['delete_status' => 'DELETED']);
        Job_Task_Completion::where('job_request_id', $request->input('job_request_id'))->update(['delete_status' => 'DELETED']);
        return response()->json($request->input('job_request_id'));
    }

    public function job_assign_retrieve($id)
    {
        // dd($id);
        $job_assignment = Job_Request::where('job_request_id', $id)->where('delete_status', 'NOT DELETED')->first();

        $job_name = DB::table('firmus_jobs')->select('job_name')->where('job_id', $job_assignment->job_id)->where('delete_status', 'NOT DELETED')->value('job_name');

        $client_name = DB::table('clients')->select('company_name')->where('client_id', $job_assignment->client_id)->where('delete_status', 'NOT DELETED')->value('company_name');

        $employees = DB::table('job__assignments')->where('job_request_id', $id)->where('delete_status', 'NOT DELETED')->get();
        $employee_details = [];
        $job_assignment_details = [];

        foreach ($employees as $employee) {
            $employee_details[$employee->emp_id] = DB::table('employees')->where('emp_id', $employee->emp_id)->value('first_name') . ' ' . DB::table('employees')->where('emp_id', $employee->emp_id)->value('last_name');
            $job_assignment_details[$employee->emp_id] = Job_Assignment::where('job_request_id', $id)->where('emp_id', $employee->emp_id)->value('job_assignment_id');
        }

        return response()->json(['data_inform' => $job_assignment, 'data_in_job_name' => $job_name, 'data_in_client' => $client_name, 'employee_details' => $employee_details, 'job_assignment_details' => $job_assignment_details]);
    }


    public function job_make_assignment(Request $request)
    {
        $emps = json_decode($request->input('jsonData'));
        $removed_employees = json_decode($request->input('removed_employees'));
        $data = Job_Request::where('job_request_id', $request->input('job_req_id'))->first();

        if ($request->input('jsonData') != "}" || $request->input('removed_employees') != "}") {

            if ($request->input('removed_employees') != "}")
                foreach ($removed_employees as $removed_employee) {
                    Job_Assignment::where('job_assignment_id', $removed_employee)->update(['delete_status' => 'DELETED']);
                }

            $emp_assignment_id = 0;
            if ($request->input('jsonData') != "}")
                foreach ($emps as $emp_id) {
                    $emp_assignment_id = Job_Assignment::create(['emp_id' => $emp_id, 'job_request_id' => $request->input('job_req_id')])->id;
                    Job_Assignment::where('job_assignment_id', $emp_assignment_id)->update(['assigned_by' => Auth::user()->emp_id]);
                }


            $job_id = DB::table('job__requests')->where('job_request_id', $request->input('job_req_id'))->where('delete_status', 'NOT DELETED')->value('job_id');
            $task_id = DB::table('tasks')->where('job_id', $job_id)->where('delete_status', 'NOT DELETED')->orderBy('task_id', 'asc')->value('task_id');
            $status = 'completed';
            $comments = "Initial Stage of client making a request";

            $task_completion_count = Job_Task_Completion::where('job_request_id', $request->input('job_req_id'))->where('task_id', $task_id)->count();

            if ($request->input('jsonData') != "}" && $task_completion_count == 0)

                Job_Task_Completion::create(['job_request_id' => $request->input('job_req_id'), 'task_id' => $task_id, 'job_assignment_id' => $emp_assignment_id, 'status' => $status, 'comments' => $comments, 'start_date' => Carbon::now(), 'end_date' => Carbon::now()]);

        } else
            return response()->json(['message' => 'error']);



        return response()->json(['message' => 'success', 'data' => $data]);
    }

    public function viewJobDetails($id)
    {
        $job = Job_Request::where('job_request_id', $id)->first();
        $employees = Job_Assignment::where('job_request_id', $id)->get();
        return Response::json(View::make('manager.job_details', array('job' => $job, 'employees' => $employees))->render());
    }
}
