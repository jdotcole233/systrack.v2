<?php

namespace App\Http\Controllers;

use App\Models\{Payment_Transaction, Job_Request, Job, Contact};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth, Response, View};

class FinanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('financeOfficer');
    }

    public function viewJobs ($user) {
        //->where('delete_status', 'NOT DELETED')
    	$job_requests = Job_Request::all()->where('delete_status', 'NOT DELETED');
    	return view('finance.jobs', compact('job_requests','user'));
    }


    public function makePayment (Request $request) {
        $job_request_id = Job_Request::where('reference_number', $request->input('reference_number'))->value('job_request_id');
//        dd($job_request_id);
        $payment_date = $request->input('payment_date');
        $payment_status = $request->input('status_of_payment');
//        dd($payment_status);
        $mode_of_payment = $request->input('mode_of_payment');
        $amount_paid = $request->input('amount_paid');
        $amount_deficit = $request->input('amount_deficit');
        $payment_time = $request->input('payment_time');
        $remark = $request->input('remark');

        if($payment_status == "REFUND") {
            Job_Request::where('reference_number', $request->input('reference_number'))->update(['job_cost' => $request->input('job_cost')]);
        } else if ($payment_status != "PREFINANCED")
            switch ($amount_deficit) {
                case 0 : $payment_status = 'FULL PAYMENT';
                    break;
                case $amount_deficit > 0 : $payment_status = 'PART PAYMENT';
                    break;
                default : $payment_status = 'PART PAYMENT';
            }


        Payment_Transaction::create(['job_request_id' => $job_request_id, 'payment_date' => $payment_date, 'payment_status' => $payment_status, 'mode_of_payment' => $mode_of_payment, 'amount_paid' => $amount_paid, 'amount_deficit' => $amount_deficit, 'payment_time' => $payment_time, 'remark' => $remark]);

        Job_Request::where('reference_number', $request->input('reference_number'))->update(['status' => $payment_status]);

        return response()->json(['message' => 'success']);
    }

    public function viewTransactions ($ref_no) {

        $job_request_id = Job_Request::where('reference_number', $ref_no)->value('job_request_id');
        $transactions = Payment_Transaction::where('job_request_id', $job_request_id)->get();
        return Response::json(View::make('finance.transactions', array('transactions' => $transactions))->render());
    }

    public function financeIndex($user){
        return view('finance.home',compact('user'));
    }

    public function financeReports($user){
        return view('finance.reports',compact('user'));
    }

    public function getStats () {
        $refunded_payments = DB::table('payment__transactions')->join('job__requests', 'payment__transactions.job_request_id', '=', 'job__requests.job_request_id')->where('payment_status', 'REFUND')->distinct()->count();
        $complete_payments = DB::table('payment__transactions')->join('job__requests', 'payment__transactions.job_request_id', '=', 'job__requests.job_request_id')->where('payment_status', 'FULL PAYMENT')->count();
        $total_payments = DB::table('payment__transactions')->join('job__requests', 'payment__transactions.job_request_id', '=', 'job__requests.job_request_id')->count();
        $jobs = Job_Request::all()->count();
        $contacts = Contact::all()->count();
        $pending_payments = DB::table('payment__transactions')->join('job__requests', 'payment__transactions.job_request_id', '=', 'job__requests.job_request_id')->where('payment_status', '<>', 'FULL PAYMENT')->count();
        return response()->json([
            'jobs' => $jobs,
            'complete_payments' => $complete_payments,
            'total_payments' => $total_payments,
            'refunded_payments' => $refunded_payments,
            'contacts' => $contacts,
            'pending_payments' => $pending_payments
        ]);
    }
}
