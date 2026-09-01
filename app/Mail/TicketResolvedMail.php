<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TicketResolvedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $resolution;
    public $confirmUrl;
    public $returnUrl;
    public $ticketUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($ticket, $resolution, $confirmUrl, $returnUrl)
    {
        $this->ticket = $ticket;
        $this->resolution = $resolution;
        $this->confirmUrl = $confirmUrl;
        $this->returnUrl = $returnUrl;
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
        return $this->subject('Ticket #' . ($this->ticket->ticket_id ?? '') . ' has been resolved')
                    ->view('emails.ticket_resolved');
    }
}
