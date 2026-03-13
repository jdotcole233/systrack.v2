<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FirmusJobAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assigned_to;
    public $action;
    public $job_name;
    public $reference_number;
    public $created_date;
    public $assignee_from;

    public function __construct($assigned_to, $action, $job_name, $ref_number, $created_date, $assignee_from)
    {
        $this->assigned_to = $assigned_to;
        $this->action = $action;
        $this->job_name = $job_name;
        $this->reference_number = $ref_number;
        $this->created_date = $created_date;
        $this->assignee_from = $assignee_from;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: strtoupper("$this->job_name  with reference $this->reference_number Has been Assigned to you"),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.staffJobAssignmentEmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
