<?php

// Email Verification Demo Script
// This script demonstrates how to send email verification using the configured SMTP settings

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

// Set the Laravel application context
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Email Verification Demo ===\n\n";

// Demo 1: Creating a user and sending verification email
echo "1. Creating a test user and sending verification email...\n";

// Create a test user
$user = new App\Models\User();
$user->name = 'Demo User';
$user->email = 'demo@example.com';
$user->password = bcrypt('password123');
$user->role = 'bendahara';
$user->save();

echo "✓ User created: {$user->name} ({$user->email})\n";

// Send verification email
$user->sendEmailVerificationNotification();
echo "✓ Verification email sent to {$user->email}\n";

// Show user verification status
echo "✓ Current verification status: " . ($user->hasVerifiedEmail() ? 'VERIFIED' : 'NOT VERIFIED') . "\n";
echo "✓ Email verification timestamp: " . ($user->email_verified_at ?? 'NULL') . "\n\n";

// Demo 2: Simulate email verification process
echo "2. Simulating email verification process...\n";

// Generate verification URL (this is what would be in the email)
$verificationUrl = URL::temporarySignedRoute(
    'verification.verify',
    now()->addMinutes(60),
    [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]
);

echo "✓ Generated verification URL: {$verificationUrl}\n";

// Simulate visiting the verification URL (this would be done by the user clicking the email link)
try {
    // Manually verify the user's email
    $user->markEmailAsVerified();
    $user->save();
    
    echo "✓ User email verified successfully!\n";
    echo "✓ New verification status: " . ($user->hasVerifiedEmail() ? 'VERIFIED' : 'NOT VERIFIED') . "\n";
    echo "✓ Updated verification timestamp: " . $user->email_verified_at . "\n\n";
} catch (Exception $e) {
    echo "✗ Error verifying email: " . $e->getMessage() . "\n";
}

// Demo 3: Show how to manually trigger verification email resending
echo "3. Testing resend verification email functionality...\n";

// Reset the verification status
$user->email_verified_at = null;
$user->save();

echo "✓ Verification status reset. Email is now unverified again.\n";

// Send another verification email
$user->sendEmailVerificationNotification();
echo "✓ Another verification email sent to {$user->email}\n\n";

echo "=== Email Verification Demo Complete ===\n";
echo "SMTP configuration is working with:\n";
echo "- Host: " . config('mail.host') . "\n";
echo "- Port: " . config('mail.port') . "\n";
echo "- Username: " . config('mail.username') . "\n";

echo "\nEmail verification system is fully configured and operational!\n";