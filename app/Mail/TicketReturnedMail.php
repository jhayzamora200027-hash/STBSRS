<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketReturnedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $ticketReturn;

    public function __construct($ticket, $ticketReturn)
    {
        $this->ticket = $ticket;
        $this->ticketReturn = $ticketReturn;
    }

    public function build()
    {
        return $this->subject('Ticket #' . ($this->ticket->ticket_id ?? '') . ' has been returned')
            ->view('emails.ticket_returned');
    }
}
