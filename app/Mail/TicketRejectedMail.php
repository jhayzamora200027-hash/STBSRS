<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TicketRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $resolution;
    public $ticketUrl;

    public function __construct($ticket, $resolution)
    {
        $this->ticket = $ticket;
        $this->resolution = $resolution;
        $this->ticketUrl = URL::temporarySignedRoute(
            'ticket.email.redirect',
            now()->addMinutes(30),
            ['ticket_id' => $ticket->ticket_id]
        );
    }

    public function build()
    {
        return $this->subject('Ticket #' . ($this->ticket->ticket_id ?? '') . ' has been rejected')
            ->view('emails.ticket_rejected');
    }
}