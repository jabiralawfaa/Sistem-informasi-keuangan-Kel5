<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {--to=jabiralawfaa@gmail.com : Email address to send test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to validate SMTP configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $toEmail = $this->option('to');

        $this->info("Preparing to send test email to: {$toEmail}");

        $details = [
            'title' => 'Test Email from Sistem Informasi Keuangan',
            'body' => 'Ini adalah email percobaan untuk menguji konfigurasi email SMTP. Jika Anda menerima email ini, maka konfigurasi berhasil.'
        ];

        try {
            Mail::to($toEmail)->send(new TestMail($details));

            $this->info("✅ Test email sent successfully to {$toEmail}");
            $this->info("   Check your inbox/spam folder for the email.");

            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            $this->error("   Please check your .env mail configuration.");

            return 1;
        }
    }
}
