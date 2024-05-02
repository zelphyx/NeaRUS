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

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $resetUrl = config('app.url') . '/reset-password/' . $this->user->reset_password_token;

        return $this->view('emails.reset-password')
            ->with(['resetUrl' => $resetUrl]);
    }
}
