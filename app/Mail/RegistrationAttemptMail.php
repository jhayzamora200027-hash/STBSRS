<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationAttemptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $name) {}

    public function build(): static
    {
        return $this->subject('Someone tried to register your STBSRS email address')
            ->view('emails.registration_attempt');
    }
}