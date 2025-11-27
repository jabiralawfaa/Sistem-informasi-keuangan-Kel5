<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail; // Import the Mail facade
use App\Mail\MailpitTestMail; // Import your Mailable class

class SendTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // You can change 'mail:test' to whatever you like
    protected $signature = 'mail:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a test email to Mailpit for testing purposes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Attempting to send a test email...');

        // This is your original code, now in the right place
        Mail::to('testing@mailpit.test')->send(new MailpitTestMail());

        $this->info('Test email sent successfully!');
    }
}
