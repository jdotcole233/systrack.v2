<?php

namespace App\Http\Controllers;

use App\Models\{Job_Assignment, Job_Task_Completion, Job_Completion, Activity, Contact, Job_Request, Task, Client};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Response, View};
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(middleware: 'employee');
    }

    public function employeeJobs($user)
    {
        $my_jobs = Job_Assignment::where('emp_id', Auth::user()->emp_id)->where('delete_status', 'NOT DELETED')->get();
        return view('employee.jobs', compact('my_jobs', 'user'));
    }

    public function employeeIndex()
    {
        return view('employee.home');
    }

    public function employeeReports()
    {
        return view('employee.reports');
    }


    public function save_job_task(Request $request)
    {

        $start_date = DB::table('job__task__completions')
            ->where('job_request_id', $request->input('job_request_id'))
            ->where('delete_status', 'NOT DELETED')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->value('end_date');

        $job_task = Job_Task_Completion::create($request->all());

        Job_Task_Completion::where('job_task_completion_id', $job_task->id)
            ->update(['start_date' => $start_date]);

        if ($request->input('status') == "completed") {
            Job_Task_Completion::where('job_task_completion_id', $job_task->id)
                ->update(['end_date' => $job_task->created_at]);
        }

        $completed = DB::table('job__task__completions')
            ->where('job_request_id', $request->input('job_request_id'))
            ->where('delete_status', 'NOT DELETED')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->value('task_id');

        $job_request = Job_Request::where('job_request_id', $request->input('job_request_id'))
            ->first();

        $last = Task::where('task_id', $completed + 1)
            ->where(
                'job_id',
                $job_request->job_id
            )->first();
        if ($last == null) {
            $start_date = DB::table('job__task__completions')

                ->where('job_request_id', $request->input('job_request_id'))
                ->where('delete_status', 'NOT DELETED')
                ->where('status', 'completed')
                ->orderBy('created_at', 'asc')
                ->value('end_date');
            $job = Job_Completion::create($request->all());
            Job_Completion::where('job_completion_id', $job->id)
                ->update(['end_date' => $job->created_at, 'start_date' => $start_date]);
            Job_Request::where('job_request_id', $request->input('job_request_id'))
                ->update(['renewal_date' => $request->input('renewal_date')]);
        }
        return response()->json(['success' => $start_date]);
    }


    public function getStats()
    {
        $assigned_jobs = Job_Assignment::where('emp_id', Auth::user()->emp_id)->where('delete_status', 'NOT DELETED')->count();
        // Job_Request::all()->count();
        $completed_jobs = DB::table('job__completions')->join('job__assignments', 'job__completions.job_request_id', 'job__assignments.job_request_id')->where('job__assignments.emp_id', Auth::user()->emp_id)->count();
        $unassigned_jobs = Job_Assignment::where('emp_id', Auth::user()->emp_id)->where('delete_status', 'DELETED')->count();
        $pending_jobs = DB::table('job__assignments')->leftJoin('job__completions', 'job__assignments.job_request_id', 'job__completions.job_request_id')->where('job__assignments.emp_id', Auth::user()->emp_id)->count();
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

    public function employeeClients($user)
    {
        $client_info = DB::table('clients')
            ->where('delete_status', 'NOT DELETED')
            ->latest('created_at')
            ->get();

        $current_date = Carbon::now();
        $last_month = Carbon::now()->subDays(30);

        $new_client_information = Client::whereBetween('created_at', [$last_month->toDateTimeString(), $current_date->toDateTimeString()])
            ->where('delete_status', 'NOT DELETED')
            ->orderBy('created_at', 'desc')
            ->get();

        // Response::json($new_client_information);
        return view('employee.clients', compact('client_info', 'new_client_information', 'user'));
    }

    public function firmus_client_send(Request $request)
    {
        $back_infor = Client::create($request->except('_token'));

        return response()->json(["successful" => "Client Added Successfully", "Data_back" => $back_infor]);
    }


    public function firmus_client_edit($id)
    {
        //Client::where('client_id',$id)->update($request->except('_token'));
        $client_e_info = DB::table('clients')->select('*')->where('client_id', $id)->where('delete_status', 'NOT DELETED')->first();

        return response()->json($client_e_info);
    }

    public function firmus_client_real_edit(Request $request, $id)
    {
        $editted_detail = Client::where('client_id', $id)->where('delete_status', 'NOT DELETED')->update($request->except('_token'));

        return response()->json(['message' => 'Client Detail updated successfully', 'datails' => $editted_detail]);
    }


    public function firmus_client_delete($id)
    {
        $delete_detail = DB::table('clients')->where('client_id', $id)->update(['delete_status' => 'DELETED']);


        return response()->json($delete_detail);

    }


    public function viewJobRequests($user)
    {
        $job_requests = Job_Request::join('jobs', 'job__requests.job_id', 'jobs.job_id')->where('jobs.delete_status', 'NOT DELETED')->where('job__requests.delete_status', 'NOT DELETED')->select('job__requests.*')->get();
        // dd($job_requests);
        $clients = Client::all()->where('delete_status', 'NOT DELETED');
        $jobs = Job::all()->where('delete_status', 'NOT DELETED');
        $employees = Employee::where('position', '<>', 'Accountant')->where('delete_status', 'NOT DELETED')->get();
        return view('employee.jobs', compact('jobs', 'clients', 'job_requests', 'employees', 'user'));
    }

    //    public function viewJobAssignments () {
//        $jobs = Job_Assignment::all();
//        return view('manager.jobs', 'jobs');
//    }

    public function addJobRequest(Request $request)
    {
        $new_job_added = Job_Request::create($request->all());
        $job_name = DB::table('jobs')->select('job_name')->where('job_id', $new_job_added->job_id)->where('delete_status', 'NOT DELETED')->first()->job_name;
        Job_Request::where('job_request_id', $new_job_added->id)->update(['created_by' => Auth::user()->emp_id, 'renewal_status' => 'NOT RENEWED']);
        $client_name = DB::table('clients')->select('company_name')->where('client_id', $new_job_added->client_id)->where('delete_status', 'NOT DELETED')->first()->company_name;
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

        $job_name = DB::table('jobs')->select('job_name')->where('job_id', $job_assignment->job_id)->where('delete_status', 'NOT DELETED')->value('job_name');

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
        info("Job details id " . json_encode($id));
        $job = Job_Request::where('job_request_id', $id)->first();
        $employees = Job_Assignment::where('job_request_id', $id)->get();
        return Response::json(View::make('employee.job_details', array('job' => $job, 'employees' => $employees))->render());
    }

}
