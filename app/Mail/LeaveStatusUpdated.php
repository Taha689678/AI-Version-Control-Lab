<?php

namespace App\Mail;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Request Status Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // For simplicity, using a markdown view or generic text view
        // We will create a simple view for this.
        return new Content(
            view: 'emails.leave_status',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
