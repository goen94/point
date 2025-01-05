<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $username)
    {
        $this->url = $url;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Login to Your Account')
            ->view('emails.auth.notification')
            ->with(['url' => $this->url, 'username' => $this->username]);
    }
}
