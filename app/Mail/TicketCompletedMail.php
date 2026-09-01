<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TicketCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $completionType;
    public $ticketUrl;

    public function __construct($ticket, string $completionType = 'completed')
    {
        $this->ticket = $ticket;
        $this->completionType = $completionType;
        $this->ticketUrl = URL::temporarySignedRoute(
            'ticket.email.redirect',
            now()->addMinutes(30),
            ['ticket_id' => $ticket->ticket_id]
        );
    }

    public function build()
    {
        return $this->subject('Ticket #' . ($this->ticket->ticket_id ?? '') . ' completed')
            ->view('emails.ticket_completed');
    }
}
