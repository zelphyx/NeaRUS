<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetLink;

    public function __construct(User $user,$resetLink)
    {
        $this->user = $user;
        $this->resetLink = $resetLink;
    }

    public function build()
    {
        return $this->subject('Reset Password Notification')
            ->view('emails.reset-password');
    }
}
