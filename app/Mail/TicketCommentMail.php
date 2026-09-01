<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TicketCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $comment;
    public $isReply;
    public $ticketUrl;

    public function __construct($ticket, $comment, bool $isReply = false)
    {
        $this->ticket = $ticket;
        $this->comment = $comment;
        $this->isReply = $isReply;
        $this->ticketUrl = URL::temporarySignedRoute(
            'ticket.email.redirect',
            now()->addMinutes(30),
            ['ticket_id' => $ticket->ticket_id]
        );
    }

    public function build()
    {
        $subject = $this->isReply ? 'New reply on ticket #' : 'New comment on ticket #';

        return $this->subject($subject . ($this->ticket->ticket_id ?? ''))
            ->view('emails.ticket_comment');
    }
}
