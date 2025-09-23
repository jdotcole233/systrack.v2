<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


     public $client_name;
     public $renewal_date;
     public $job_name;
     public $reference_number;
     public $created_date;
     public $manager_email;

    public function __construct($client_name, $renewal_date, $job_name, $ref_number,$created_date,$manager_email)
    {
        $this->client_name = $client_name;
        $this->renewal_date = $renewal_date;
        $this->job_name = $job_name;
        $this->reference_number = $ref_number;
        $this->created_date = $created_date;
        $this->manager_email = $manager_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject_tobe_sent = "FRIENDLY REMINDER FOR  ". $this->reference_number;
        return $this->from('noreply@firmusadvisoryapp.com')->subject($subject_tobe_sent)
        ->view('emails.reminderClientEmail');
    }
}
