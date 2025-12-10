<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        $resetUrl = route('password.reset', $this->token);

        return $this->subject('Recuperar password')->view('emails.password_reset')->with([
            'resetUrl' => $resetUrl,
        ]);
    }
}
