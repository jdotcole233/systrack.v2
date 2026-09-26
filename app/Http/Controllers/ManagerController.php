<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client, Employee, Job_Assignment, Job, Job_Request, Contact, Job_Completion, Payment_Transaction};
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
        $job_request = Job_Request::where('delete_status', 'NOT DELETED')->get();

        $job_assignment = Job_Assignment::where('emp_id', Auth::user()->emp_id)
            ->where('delete_status', 'NOT DELETED')
            ->get();

        $job_assignment_count = $job_assignment->whereIn('job_request_id', $job_request->pluck('job_request_id'))
            ->count();

        $job_completion_count = Job_Completion::where('delete_status', 'NOT DELETED')
            ->whereIn('job_request_id', $job_assignment->pluck('job_assignment_id'))
            ->get()
            ->count();

        $pending_jobs_count = $job_assignment->count() - $job_completion_count;

        $client_count = Client::where('delete_status', 'NOT DELETED')->get()->count();
        $employee_count = Employee::where('delete_status', 'NOT DELETED')->get()->count();
        $job_request_count = $job_request->count();

        return view('manager.home', compact('user', 'client_count', 'employee_count', 'pending_jobs_count', 'job_request_count'));
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

    // public function managerMyJobs($user)
    // {
    //     $my_jobs = Job_Assignment::where('emp_id', Auth::user()->emp_id)
    //         ->where('delete_status', 'NOT DELETED')
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    //     return view('employee.jobs', compact('my_jobs', 'user'));
    // }

         public function managerMyJobs($user)
    {
        $assignments = Job_Assignment::query()
            ->where('emp_id', Auth::user()->emp_id)
            ->where('delete_status', 'NOT DELETED')
            ->whereHas('job_request', fn ($q) => $q->where('delete_status', 'NOT DELETED'))
            ->with([
                'assigner:emp_id,first_name,last_name',
                'job_request.client:client_id,company_name,email',
                'job_request.job' => fn ($q) => $q->where('delete_status', 'NOT DELETED'),
                'job_request.job.tasks' => fn ($q) => $q
                    ->where('delete_status', 'NOT DELETED')
                    ->orderBy('task_id'), // swap for a `sequence` column if you add one
                'job_request.job_tasks_completion' => fn ($q) => $q
                    ->where('delete_status', 'NOT DELETED')
                    ->orderBy('created_at'),
                'job_request.completion:job_request_id,end_date',
                // Only the columns the page needs — never serialize whole employee rows.
                'job_request.assignees:employees.emp_id,employees.first_name,employees.last_name,employees.company_email',
            ])
            ->orderByDesc('created_at')
            ->get();
 
        $jobs = $assignments
            ->map(fn (Job_Assignment $assignment) => $this->presentAssignment($assignment))
            ->values();
 
        // $user is still passed through in case employee.my-jobs-template uses it.
        return view('employee.jobs', compact('jobs', 'user'));
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
        $report_data = [];
        $total = 0;

        return view('manager.reports', compact('user', 'report_data', 'total'));
    }

    function getQueriedResults(Request $request, $user)
    {

        info("request " . json_encode($request->all()));

        if ($request->job_id == "allJobs") {
            $report_data = job_request::join('clients', 'job__requests.client_id', 'clients.client_id')
                ->join('firmus_jobs', 'job__requests.job_id', 'firmus_jobs.job_id')
                ->join('employees', 'job__requests.created_by', 'employees.emp_id')
                ->select("job__requests.created_at As date_logged", "job_name", "company_name", "reference_number", "first_name", "last_name")
                ->whereBetween('job__requests.created_at', [$request->from_date, $request->to_date])
                ->latest('job__requests.created_at')
                ->where('job__requests.delete_status', 'NOT DELETED')
                ->get();

            // $total = job_request::whereBetween('job__requests.created_at', [$request->from_date, $request->to_date])
            //     ->where('job__requests.delete_status', 'NOT DELETED')
            //     ->sum("job_cost");
        } else {
            $report_data = job_request::where('job__requests.job_id', $request->job_id)
                ->join('clients', 'job__requests.client_id', 'clients.client_id')
                ->join('firmus_jobs', 'job__requests.job_id', 'firmus_jobs.job_id')
                ->join('employees', 'job__requests.created_by', 'employees.emp_id')
                ->select("job__requests.created_at As date_logged", "job_name", "company_name", "reference_number", "first_name", "last_name")
                ->whereBetween('job__requests.created_at', [$request->from_date, $request->to_date])
                ->latest('job__requests.created_at')
                ->where('job__requests.delete_status', 'NOT DELETED')
                ->get();

            // $total = job_request::where('job__requests.job_id', $request->job_id)
            //     ->whereBetween('job__requests.created_at', [$request->from_date, $request->to_date])
            //     ->where('job__requests.delete_status', 'NOT DELETED')
            //     ->sum("job_cost");
        }


        info($report_data);

        // return response()->json(["data" => $test, "total" => $total]);
        return view('manager.reports', compact('user', 'report_data'));
    }


        /**
     * Everything one table row and its modal need, as a plain array.
     * The view renders from this and the JS reads the same data via @json.
     */
    private function presentAssignment(Job_Assignment $assignment): array
    {
        $request  = $assignment->job_request;
        $progress = $request->taskProgress();
        $current  = $progress['current'];
        $details  = is_array($request->details) ? $request->details : [];
        $assigner = $assignment->assigner;
 
        return [
            'id'                => $request->job_request_id,
            'assignment_id'     => $assignment->job_assignment_id,
            'reference'         => $request->reference_number,
            'job_name'          => $request->job?->job_name ?? '—',
            'client'            => $request->client?->company_name ?? '—',
            'client_email'      => $request->client?->email,
            'email_suggestions' => $this->emailSuggestions($request->client?->email, $details),
            'assigned_by'       => $assigner ? trim($assigner->first_name . ' ' . $assigner->last_name) : '—',
            'applicant'         => $details['NAME OF APPLICANT'] ?? $details['APPLICANT NAME'] ?? 'N/A',
            'assignment_status' => $assignment->assignment_status,
            'assigned_on'       => $assignment->created_at?->format('d M Y, H:i'),
            'assigned_on_sort'  => $assignment->created_at?->timestamp,
            'end_date'          => $this->dateOnly($request->completion?->end_date),
            'renewal_date'      => $this->dateOnly($request->renewal_date),
            'current_task'      => $current ? [
                'id'     => $current->task_id,
                'name'   => $current->task_name,
                'status' => $progress['statuses'][$current->task_id] ?? null,
            ] : null,
            'is_final_task'     => $progress['is_final'],
            'is_done'           => $progress['is_done'],
            'stages'            => $progress['stages'],
            'assignees'         => $request->assignees
                ->map(fn ($e) => [
                    'name'  => trim($e->first_name . ' ' . $e->last_name),
                    'email' => $e->email,
                ])
                ->values()
                ->all(),
        ];
    }

     
    private function dateOnly($value): ?string
    {
        return $value ? Carbon::parse($value)->toDateString() : null;
    }
 
    /**
     * Client email on file plus any email addresses found in THIS request's details
     * (the old code pulled details from every request the client ever made).
     */
    private function emailSuggestions(?string $clientEmail, array $details): array
    {
        return collect($details)
            ->flatten()
            ->filter(fn ($v) => is_string($v) && filter_var(trim($v), FILTER_VALIDATE_EMAIL))
            ->map(fn ($v) => strtolower(trim($v)))
            ->prepend($clientEmail ? strtolower($clientEmail) : null)
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
