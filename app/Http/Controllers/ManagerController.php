<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client, Employee, Job_Assignment, Job, Job_Request, Contact, Payment_Transaction};
use Carbon\Carbon;
use Illuminate\Support\Facades\{DB, Auth, Response};

class ManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('manager');
    }


    public function firmus_client_send(Request $request)
    {
        $back_infor = Client::create($request->except('_token'));
        return response()->json(["successful" => "Client Added Successfully", "Data_back" => $back_infor]);
    }

    public function firmus_client_edit($id)
    {
        //Client::where('client_id',$id)->update($request->except('_token'));
        $client_e_info = DB::table('clients')
            ->select('*')
            ->where('client_id', $id)
            ->where('delete_status', 'NOT DELETED')
            ->first();

        return response()->json($client_e_info);
    }

    public function firmus_client_real_edit(Request $request, $id)
    {
        $editted_detail = Client::where('client_id', $id)
            ->where('delete_status', 'NOT DELETED')
            ->update($request->except('_token'));

        return response()->json(['message' => 'Client Detail updated successfully', 'datails' => $editted_detail]);
    }

    public function firmus_new_clients()
    {
        //    	$date = Carbon::now();
//    	$date = new Carbon();
        $current_date = Carbon::now();
        $last_month = Carbon::now()->subDays(30);
        $new_client_information = Client::whereBetween('created_at', [$last_month->toDateTimeString(), $current_date->toDateTimeString()])
            ->where('delete_status', 'NOT DELETED')
            ->latest('created_at')
            ->get();

        //    	$new_client_information = DB::table('clients')->select('*')->where('created_at','<',$date)->where('delete_status', 'NOT DELETED')->get();
        return response()->json(["data_info" => $new_client_information]);
    }

    public function firmus_client_delete($id)
    {
        $delete_detail = DB::table('clients')->where('client_id', $id)
            ->update(['delete_status' => 'DELETED']);
        return response()->json($delete_detail);

    }


    public function managerClients($user)
    {
        $client_info = DB::table('clients')
            ->select('*')
            ->where('delete_status', 'NOT DELETED')
            ->latest('created_at')
            ->get();
        $current_date = Carbon::now();
        $last_month = Carbon::now()->subDays(30);
        $new_client_information = Client::whereBetween('created_at', [$last_month->toDateTimeString(), $current_date->toDateTimeString()])->where('delete_status', 'NOT DELETED')
            ->orderBy('created_at', 'desc')
            ->get();
        // Response::json($new_client_information);
        return view('manager.clients', compact('client_info', 'new_client_information', 'user'));
    }


    public function managerIndex($user)
    {
        return view('manager.home', compact('user'));
    }

    public function getStats()
    {
        $jobs = Job_Request::all()->count();
        // Job_Request::all()->count();
        $employees = Employee::all()->count();
        $clients = Client::all()->count();
        $pending_jobs = Job_Request::where('status', 'pending')->count();
        $contacts = Contact::all()->count();
        $pending_payments = DB::table('payment__transactions')->join('job__requests', 'payment__transactions.job_request_id', '=', 'job__requests.job_request_id')->where('payment_status', '<>', 'FULL PAYMENT')->count();
        return response()->json([
            'jobs' => $jobs,
            'employees' => $employees,
            'clients' => $clients,
            'pending_jobs' => $pending_jobs,
            'contacts' => $contacts,
            'pending_payments' => $pending_payments
        ]);

    }

    public function managerMyJobs($user)
    {
        $my_jobs = Job_Assignment::where('emp_id', Auth::user()->emp_id)->where('delete_status', 'NOT DELETED')->get();
        return view('employee.jobs', compact('my_jobs', 'user'));
    }

    public function managerEmployees($user)
    {

        $employee_manager_view = Employee::all();

        return view('manager.employees', compact('user', 'employee_manager_view'));
    }

    // public function managerReports($user){
    //     return view('manager.reports',compact('user'));
    // }

    function index($user)
    {
        return view('manager.reports', compact('user'));
    }

    function getQueriedResults(Request $request)
    {

        if ($request->job_id == "allJobs") {
            $test = job_request::join('clients', 'job__requests.client_id', 'clients.client_id')
                ->join('jobs', 'job__requests.job_id', 'jobs.job_id')
                ->select("job__requests.created_at As date_logged", "job_name", "company_name", "job_cost", "job_request_id")
                ->whereBetween('job__requests.created_at', [$request->from_date, $request->to_date])
                ->latest('job__requests.created_at')
                ->where('job__requests.delete_status', 'NOT DELETED')
                ->get();

            $total = job_request::whereBetween('job__requests.created_at', [$request->from_date, $request->to_date])
                ->where('job__requests.delete_status', 'NOT DELETED')
                ->sum("job_cost");
        } else {
            $test = job_request::where('job__requests.job_id', $request->job_id)
                ->join('clients', 'job__requests.client_id', 'clients.client_id')
                ->join('jobs', 'job__requests.job_id', 'jobs.job_id')
                ->select("job__requests.created_at As date_logged", "job_name", "company_name", "job_cost", "job_request_id")
                ->whereBetween('job__requests.created_at', [$request->from_date, $request->to_date])
                ->latest('job__requests.created_at')
                ->where('job__requests.delete_status', 'NOT DELETED')
                ->get();

            $total = job_request::where('job__requests.job_id', $request->job_id)
                ->whereBetween('job__requests.created_at', [$request->from_date, $request->to_date])
                ->where('job__requests.delete_status', 'NOT DELETED')
                ->sum("job_cost");
        }



        return response()->json(["data" => $test, "total" => $total]);
    }

}
