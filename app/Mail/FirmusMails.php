<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FirmusMails extends Mailable
{
    use Queueable, SerializesModels;

    public $client_message;
    public $client_name;
    public $job_reference_number;
    public $message_subject;
    public $job_title;
    public $review_company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client_message,$message_subject = "(no subject)", $client_name, $reference_number, $job_title, $review_company)
    {
         $this->client_message = $client_message;
         $this->message_subject = $message_subject;
         $this->client_name = $client_name;
         $this->job_reference_number = $reference_number;
         $this->job_title = $job_title;
         $this->review_company = $review_company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact.systrack@firmusadvisory.com')->subject($this->message_subject)
        ->view('emails.firmusClientEmail');
    }
}
