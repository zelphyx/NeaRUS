<?php

namespace App\Mail;

use AllowDynamicProperties;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

#[AllowDynamicProperties] class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(User $user,$verificationLink)
    {
        $this->user = $user;
        $this->verificationLink = $verificationLink;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify Your Email Address')->view('emails.verify');
    }
}
