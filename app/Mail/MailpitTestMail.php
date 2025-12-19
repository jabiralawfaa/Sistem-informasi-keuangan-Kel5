<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailpitTestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Test Email for Mailpit')
                    ->view('emails.mailpit-test')
                    ->with([
                        'title' => 'Mailpit Test Email',
                        'body' => 'This is a test email to verify that Mailpit is working correctly.'
                    ]);
    }
}
