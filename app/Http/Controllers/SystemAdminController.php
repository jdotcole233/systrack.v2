<?php

namespace App\Http\Controllers;

use App\Models\{Task, Employee, Contact, User, Job, Activity};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SystemAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('systemAdmin');
    }

    public function employee_in_system(Request $request)
    {
        $emp_data = Employee::create($request->all());

        $user_log = new User;
        $user_log->username = $emp_data->company_email;
        $user_log->password = bcrypt(123456);
        $user_log->emp_id = $emp_data->id;
        $user_log->created_at = $emp_data->created_at;
        $user_log->updated_at = $emp_data->updated_at;
        $user_log->log_status = "FIRST CREATE";
        $user_log->save();

        $emp_log_detail = User::all()->last();

        return response()->json(['message' => 'successfully added', 'employe_log_details' => $emp_log_detail]);
    }

    public function employee_in_system_retrieve($user)
    {
        $emp_information = Employee::where('delete_status', 'NOT DELETED')
        ->orderBy('created_at', 'desc')
        ->get();
        // $emp_log_detail = User::all()->last();
        return view('admin.employees', compact('emp_information', 'user'));
    }

    public function employee_in_update_record($id)
    {
        $emp_update_information = DB::table('employees')->select('*')->where('emp_id', $id)->where('delete_status', 'NOT DELETED')->first();


        return response()->json($emp_update_information);
    }

    public function employee_in_update_record_individual(Request $request, $id)
    {
        Employee::where('emp_id', $id)->update($request->except('_token'));
        $emp = Employee::where('emp_id', $id)->first();
        DB::table('users')->where('emp_id', $id)->update(['username' => $emp->company_email]);
        return response()->json(['msg' => 'Updated Successfully', 'emp' => $emp]);
    }


    public function firmus_employee_delete($id)
    {
        $delete_detail = DB::table('employees')->where('emp_id', $id)->update(['delete_status' => 'DELETED']);
        User::where('emp_id', $id)->delete();
        return response()->json($delete_detail);

    }


    public function send_contact_information(Request $request)
    {
        Contact::create($request->all());
        Session::flash('contact_success', 'Contact added successfully');

        return back();
    }

    public function contact_information_retrieve($user)
    {
        $myDate = date('Y-m-d H:i:s');
        $job_contacts = Contact::all();
        //More work to be done on this query
        $current_contact = Contact::all()->where('created_at', '<=', $myDate);

        return view('admin.address-book', compact('job_contacts', 'current_contact', 'user'));
    }

    public function contact_ind_retrieve($id)
    {
        $from_in_infor = Contact::find($id)->first();
        return back();
    }

    public function add_job(Request $request)
    {
        $job_id = Job::create($request->except('_token'))->id;
        $data = Job::where('job_id', $job_id)->first();
        return response()->json(['message' => 'success', 'job_id' => $job_id, 'data' => $data]);
    }

    public function edit_job(Request $request)
    {
        Job::where('job_id', '=', $request->input('job_id'))->update($request->except('job_id', '_token', 'task', 'tasks'));
        //        Task::create($request->except('_token'));
        $data = Job::where('job_id', $request->input('job_id'))->first();
        return response()->json(['message' => 'success', 'job_id' => $request->input('job_id'), 'data' => $data]);
    }

    public function delete_job(Request $request)
    {
        Job::where('job_id', $request->input('job_id'))->update(['delete_status' => 'DELETED']);
        Task::where('job_id', $request->input('job_id'))->update(['delete_status' => 'DELETED']);
        $data = Job::where('job_id', $request->input('job_id'))->first();
        return response()->json(['message' => 'success', 'job_id' => $request->input('job_id'), 'data' => $data]);
    }

    public function view_jobs($user)
    {
        $jobs = Job::orderBy('created_at', 'desc')->get();
        return view('admin.jobs', compact('jobs', 'user'));
    }

    public function add_task(Request $request)
    {
        $tasks = json_decode($request->input('tasks'));
        $removed_tasks = json_decode($request->input('removed_tasks'));
        if (strlen($request->input('tasks')) != 0) {
            foreach ($tasks as $task => $value) {
                if (strpos($task, 'Task Name') !== false)
                    Task::create(['task_name' => $value, 'job_id' => $request->input('job_id')]);
                else
                    Task::where('task_id', $task)->update(['task_name' => $value]);
            }
        }

        if (strlen($request->input('removed_tasks')) != 0) {
            foreach ($removed_tasks as $task => $value) {
                Task::where('task_id', $task)->update(['delete_status' => 'DELETED']);
            }
        }
        return response()->json(['message' => 0]);
    }


    public function adminIndex($user)
    {
        $user_activity = Activity::where('delete_status', 'NOT DELETED')->get();
        return view('admin.home', compact('user', 'user_activity'));
    }

    public function adminReports($user)
    {
        return view('admin.reports', compact('user'));
    }

    public function adminWebStats($user)
    {
        $user_activity = Activity::where('delete_status', 'NOT DELETED')->orderBy('created_at', 'desc')->get();
        return view('admin.firmus-web-stats', compact('user', 'user_activity'));
    }

    public function getStats()
    {
        $employees = Employee::all()->count();
        $activities = Activity::all()->count();
        $current_date = Carbon::now();
        $last_month = Carbon::now()->subDays(30);
        $day_ago = Carbon::now()->subDays(1);
        $activities_this_month = DB::table('activities')->whereBetween('created_at', [$last_month->toDateTimeString(), $current_date->toDateTimeString()])->count();
        $activities_today = Activity::whereBetween('created_at', [$day_ago->toDateTimeString(), $current_date->toDateTimeString()])->count();
        return response()->json([
            'employees' => $employees,
            'activities' => $activities,
            'activities_this_month' => $activities_this_month,
            'activities_today' => $activities_today
        ]);
    }
}
