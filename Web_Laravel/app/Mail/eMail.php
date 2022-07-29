<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class eMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject, $msg;
    public function __construct($subject, $msg)
    {
        // Use this template
        // $msg = [ 'title' => null, 'body' => null ];

        // Use this syntax for send mail
        // \Mail::to('your_receiver_email@gmail.com')->send(new \App\Mail\eMail($subject, $msg));

        $this->subject = $subject;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            ->view('mail.reset_pass');
    }
}
