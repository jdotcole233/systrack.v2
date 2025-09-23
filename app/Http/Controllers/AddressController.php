<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use App\Models\{Contact, Job_Request, Task};
use App\Mail\{FirmusMails, FirmusContactAddressEmail, ClientNotificationEmail, ClientReminder};
use Illuminate\Support\Facades\{DB};


class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function send_contact_information(Request $request)
    {
        Contact::create($request->all());

        return response()->json(['contact_success' => 'Contact added successfully']);
    }

    public function contact_information_retrieve($user)
    {

        $job_contacts = Contact::all()->where('delete_status', 'NOT DELETED');
        //More work to be done on this query
        $current_date = Carbon::now();
        //        Carbon::
        $last_month = Carbon::now()->subDays(30);
        $current_contact = Contact::whereBetween('created_at', [$last_month->toDateTimeString(), $current_date->toDateTimeString()])->where('delete_status', 'NOT DELETED')->get();

        return view('address.address-book', compact('job_contacts', 'current_contact', 'user'));
    }

    public function contact_ind_retrieve($id)
    {
        $from_in_infor = Contact::find($id)->where('delete_status', 'NOT DELETED')->first();
        return back();
    }

    public function contact_retrieve($id)
    {
        $from_in_infor = Contact::where('contact_id', $id)->where('delete_status', 'NOT DELETED')->first();
        return response()->json($from_in_infor);
    }

    public function contact_update(Request $request, $id)
    {
        Contact::where('contact_id', $id)->where('delete_status', 'NOT DELETED')->update($request->except('_token'));

        $contact = Contact::where('contact_id', $id)->first();

        return response()->json(['success' => 'successful', 'data' => $contact]);
    }

    public function contact_delete($id)
    {
        //        Contact::where('contact_id',$id)->where('delete_status','NOT DELETED')->update(['delete_status' => 'DELETED']);
        return response()->json(['success' => 'successful']);
    }

    public function sendClientEmail(Request $request, Mailer $mail)
    {

        if ($request->input('choice') === "Email_Job") {
            // $name = DB::table('employees')->select('first_name','other_name','last_name','position')->where('emp_id', Auth::user()->emp_id)->where('delete_status','NOT DELETED')->first();

            $job_request = Job_Request::where('reference_number', $request->input('reference_number'))
                ->first();

            info("Job request". json_encode($job_request));

            $completed = DB::table('job__task__completions')
                ->where('job_request_id', $job_request->job_request_id)
                ->where('delete_status', 'NOT DELETED')
                ->where('status', 'completed')
                ->orderBy('created_at', 'desc')
                ->value('task_id');
            
            info("completed tasks ". json_encode($completed));

            $related_tasks = Task::where('job_id', $job_request->job_id)->get()->last();
            info("Last task ". json_encode($related_tasks));

            $review_company = false;
            if ($related_tasks->task_id == $completed) {
                $review_company = true;
            }

            $emails = explode(',', $request->input('alt_email'));
            $size_of_email = count($emails);
            if ($size_of_email > 0) {
                $to_email = $emails[0];
                $cc_email = array_slice($emails, 1);
                $cc_size = count($cc_email);
                if ($cc_size == 0) {
                    $mail->to($to_email)
                        ->send(new firmusMails($request->input('client_message'), $request->input('subject'), $request->input('client_name'), $request->input('reference_number'), $request->input('job_title'), $review_company));
                } else if ($cc_size > 0) {
                    $mail->to($to_email)
                        ->cc($cc_email)
                        ->send(new firmusMails($request->input('client_message'), $request->input('subject'), $request->input('client_name'), $request->input('reference_number'), $request->input('job_title'), $review_company));
                }
            }

            return response()->json(['message' => 'message set successfully']);
        } else if ($request->input('choice') === "Email") {
            $name = DB::table('employees')
                ->select('first_name', 'other_name', 'last_name', 'position')
                ->where('emp_id', $request->input('employee_id'))
                ->where('delete_status', 'NOT DELETED')
                ->first();
            $mail->to($request->input('contact_email'))
                ->send(new firmusContactAddressEmail($request->input('client_message'), $request->input('subject'), $name));

            return response()->json(['message' => 'message sent successfully']);
        } else if ($request->input('choice') === "SMS") {
            return response()->json(['message' => 'SERVICE NOT AVAILABLE']);
        }
    }




    public function sendRenewalReminder(Mailer $mail)
    {
        $currentDate = date("Y-m-d");
        $renewal_dates = DB::table('job__requests')->select("job_request_id", "renewal_status", "renewal_date", "created_at", "client_id", "job_id", "details", "created_by", "reference_number")->where('delete_status', 'NOT DELETED')->get();
        foreach ($renewal_dates as $renewal_date) {
            $recent_date = $renewal_date->renewal_date;
            //check if the renewal is not null
            if ($recent_date != null) {
                $status_renew = $renewal_date->renewal_status;
                $set_remainder_period = date_format(date_sub(date_create($recent_date), date_interval_create_from_date_string("60 days")), "Y-m-d");
                if ($set_remainder_period == $currentDate && $status_renew == "NOT RENEWED") {
                    //getting necessary data to send Notification as Reminder
                    $manager_email = DB::table('employees')->where('emp_id', $renewal_date->created_by)->where('delete_status', 'NOT DELETED')->value('company_email');
                    $job_name = DB::table('jobs')->where('delete_status', 'NOT DELETED')->where('job_id', $renewal_date->job_id)->value('job_name');
                    $client_name = DB::table('clients')->where('delete_status', 'NOT DELETED')->where('client_id', $renewal_date->client_id)->value('company_name');
                    $client_acc_email = json_decode($renewal_date->details);
                    $emails_to_send = [$manager_email, $client_acc_email->EMAIL];
                    $email_carbon = array_slice($emails_to_send, 1);
                    $mail->to($emails_to_send[0])->cc($email_carbon)->send(new ClientReminder($client_name, $renewal_date->renewal_date, $job_name, $renewal_date->reference_number, $renewal_date->created_at, $manager_email));
                    Job_Request::where('delete_status', 'NOT DELETED')->where('job_request_id', $renewal_date->job_request_id)->update(["renewal_status" => "RENEWAL SENT"]);
                }
            }

        }
        return response()->json("Checking Client Renewal Reminder....");
    }

    public function clientEmailNotification(Request $request, Mailer $mail)
    {
        $first_email = $request->input('emails')[0];
        $carbon_copy_mail = array_slice($request->input('emails'), 1);
        $mail->to($first_email)->cc($carbon_copy_mail)->send(new ClientNotificationEmail($request->input('message'), $request->input('reference'), $request->input('title'), $request->input('client_name')));
        return response()->json("success");
    }

}
