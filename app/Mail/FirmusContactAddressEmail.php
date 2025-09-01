<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FirmusContactAddressEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $client_message;
    public $message_subject;
    public $employee_name;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client_message,$message_subject = "(no subject)", $employee_name)
    {
         $this->client_message = $client_message;
         $this->message_subject = $message_subject;
         $this->employee_name = $employee_name;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact.systrack@firmusadvisory.com')->subject($this->message_subject)->view('emails.firmusContactEmail');
    }
}
