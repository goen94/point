<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $username;
    protected $vendor;
    protected $model;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $username, $vendor, $model)
    {
        $this->url = $url;
        $this->username = $username;
        $this->vendor = $vendor;
        $this->model = $model;
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
            ->with(['url' => $this->url, 'username' => $this->username, 'vendor' => $this->vendor, 'model' => $this->model]);
    }
}
