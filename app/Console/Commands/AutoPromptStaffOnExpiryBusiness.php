<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\Job_Completion;
use App\Models\Job_Request;
use Illuminate\Console\Command;

class AutoPromptStaffOnExpiryBusiness extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:prompt-staff-on-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Logic to prompt staff on expiry of business
        // This could involve checking for businesses that are about to expire and sending notifications to staff members

        // From the Job_Completion table check if the end date is 4 months to expiry and if so, send a email to the staff members  with the Firmus_Job details that it will be expiring in 4 months and prompt them to take necessary actions.

        Job_Completion::where('end_date', now()->addMonths(4)->toDateString())->each(function ($jobCompletion) {
            $job_request = Job_Request::find($jobCompletion->job_request_id)->with(['job_assignment']);
            // Logic to send email notification to staff members about the expiring business
            // You can use Laravel's Mail facade to send emails
            $staffEmail = $job_request->job_assignment->employee->company_email; // Assuming you have a staff_email field in your job_assignment table
            Mail::to($staffEmail)->send(new ExpiryNotification($job));
        });


        $this->info('Staff have been prompted for expiring businesses.');
    }
}
