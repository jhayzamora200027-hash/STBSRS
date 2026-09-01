<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NewTicketAdminMail extends Mailable
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
        return $this->subject('New ticket created: ' . ($this->ticket->ticket_id ?? ''))
            ->view('emails.new_ticket_admin');
    }
}
