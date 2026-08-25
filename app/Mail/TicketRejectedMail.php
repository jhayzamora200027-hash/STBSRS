<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $resolution;

    public function __construct($ticket, $resolution)
    {
        $this->ticket = $ticket;
        $this->resolution = $resolution;
    }

    public function build()
    {
        return $this->subject('Ticket #' . ($this->ticket->ticket_id ?? '') . ' has been rejected')
            ->view('emails.ticket_rejected');
    }
}