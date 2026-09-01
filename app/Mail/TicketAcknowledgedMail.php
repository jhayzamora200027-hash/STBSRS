<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TicketAcknowledgedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $ticketUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
        $this->ticketUrl = URL::temporarySignedRoute(
            'ticket.email.redirect',
            now()->addMinutes(30),
            ['ticket_id' => $ticket->ticket_id]
        );
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Ticket #' . ($this->ticket->ticket_id ?? '') . ' acknowledged')
                    ->view('emails.ticket_acknowledged');
    }
}
