<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $client_message;
     public $reference_number;
     public $job_title;
     public $client_name;

    public function __construct($message, $reference, $title, $client_name)
    {
        $this->client_message = $message;
        $this->reference_number = $reference;
        $this->job_title = $title;
        $this->client_name = $client_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@firmusadvisoryapp.com')->subject("CLIENT REQUEST ON ". $this->reference_number)
        ->view('emails.clientEmergencyEmail');
    }
}
