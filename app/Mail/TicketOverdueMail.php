<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TicketOverdueMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $ticketUrl;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
        $this->ticketUrl = URL::temporarySignedRoute(
            'ticket.email.redirect',
            now()->addMinutes(30),
            ['ticket_id' => $ticket->ticket_id]
        );
    }

    public function build()
    {
        return $this->subject('Overdue ticket: #' . $this->ticket->ticket_id)
            ->view('emails.ticket_overdue');
    }
}
