<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketResolvedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $resolution;
    public $confirmUrl;
    public $returnUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($ticket, $resolution, $confirmUrl, $returnUrl)
    {
        $this->ticket = $ticket;
        $this->resolution = $resolution;
        $this->confirmUrl = $confirmUrl;
        $this->returnUrl = $returnUrl;
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
