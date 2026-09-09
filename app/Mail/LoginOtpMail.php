<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $firstName,
        public string $otp,
        public int $minutes = 10,
    ) {}

    public function build(): static
    {
        return $this->subject('Your iSTaksyon sign-in verification code')
            ->view('emails.otp');
    }
}
