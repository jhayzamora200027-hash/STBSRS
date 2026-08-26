<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public function build(): static
    {
        return $this->subject('Your STBSRS account has been approved')
            ->view('emails.account_approved');
    }
}